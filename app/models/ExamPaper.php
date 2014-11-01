<?php

class ExamPaper extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'exam_paper';
    protected $guarded = array('id');

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = array('password', 'remember_token');


    public function add($data)
    {
        $this->column_id = $data['column_id'];
        $this->title = $data['title'];
        
        if(isset($data['score']))
            $this->score = $data['score'];

        if(isset($data['price']))
            $this->price = $data['price'];

        if(isset($data['status']))
            $this->status = $data['status'];

        if(isset($data['parent_id']))
            $this->parent_id = $data['parent_id'];

        if(isset($data['desc']))
            $this->desc = $data['desc'];
        
        return $this->save();
    }

    public function edit($data)
    {
        $update = array();
        if(isset($data['title']))
            $update['title'] = $data['title'];

        if(isset($data['price']))
            $update['price'] = $data['price'];

        if(isset($data['desc']))
            $update['desc'] = $data['desc'];

        if(isset($data['status']))
            $update['status'] = $data['status'];

        if(isset($data['score']))
        {
            $update['score'] = $data['score'];

            // 自动跟新已经添加的题目列表数据
            ExamQuestionRelation::where('exam_id', '=', $data['id'])->update( array('score' => $data['score']) );
        }

        return $this->where('id', '=', $data['id'])->update($update);
    }

    public function getList($data)
    {
        return $this->where('column_id', '=', $data['columnId'])->where('parent_id', '=', 0)->get();
    }

    public function del($id)
    {
        $list = $this->whereRaw("id = {$id} or parent_id = {$id}")->get();
        foreach ($list as $value) 
        {
            ExamQuestionRelation::where('exam_id', '=', $value['id'])->delete();
            $this->where('id', '=', $value['id'])->delete();
        }
    }

}
