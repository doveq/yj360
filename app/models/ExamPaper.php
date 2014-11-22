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
        //$this->column_id = $data['column_id'];
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
        
        if(isset($data['sort']))
            $this->sort = $data['sort'];

        if(isset($data['ordern']))
            $this->ordern = $data['ordern'];

        if(isset($data['rnum']))
            $this->rnum = $data['rnum'];

        if(isset($data['total_time']))
            $this->total_time = $data['total_time'];

        if(isset($data['loops']))
            $this->loops = $data['loops'];

        if(isset($data['time_spacing']))
            $this->time_spacing = $data['time_spacing'];

        $this->save();
        return $this->id;  // 插入的id号
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

        if(isset($data['sort']))
            $update['sort']  = $data['sort'];

        if(isset($data['ordern']))
            $update['ordern'] = $data['ordern'];

        if(isset($data['rnum']))
            $update['rnum'] = $data['rnum'];

        if(isset($data['total_time']))
            $update['total_time'] = $data['total_time'];

        if(isset($data['loops']))
            $update['loops'] = $data['loops'];

        if(isset($data['time_spacing']))
            $update['time_spacing'] = $data['time_spacing'];

        if(isset($data['score']))
        {
            $update['score'] = $data['score'];

            // 自动跟新已经添加的题目列表数据
            ExamQuestionRelation::where('exam_id', '=', $data['id'])->update( array('score' => $data['score']) );
        }

        return $this->where('id', '=', $data['id'])->update($update);
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

    /* 获取试卷列表 */
    public function getElist($data = array())
    {
        $re = $this->where('parent_id', '=', 0);

        if(!empty($data['sort']))
            $re = $re->where('sort', '=', $data['sort']);

        if(isset($data['status']) && $data['status'] != '' )
            $re = $re->where('status', '=', $data['status']);

        if(!empty($data['name']))
            $re->where('title', 'like', "%{$data['name']}%");

        return $re;
    }

    /* 获取试卷大题列表 */
    public function getClist($exam_id)
    {
        $list = $this->where('parent_id', '=', $exam_id)->orderBy('ordern', 'asc')->get();
        return $list;
    }

    /* 获取试卷大题题目列表 */
    public function getQuestions($exam_id)
    {
        $list = ExamQuestionRelation::where('exam_id', '=', $exam_id)->orderBy('ordern', 'asc')->get();
        return $list;
    }
    
    /* 随机获取大题题目列表 */
    public function getRandQuestions($exam_id, $num)
    {
        $list = ExamQuestionRelation::where('exam_id', '=', $exam_id)->orderByRaw("RAND()")->take($num)->get();
        return $list;
    }

    /* 获取试卷大题题目总数 */
    public function getQuestionsCount($exam_id)
    {
        $list = ExamQuestionRelation::where('exam_id', '=', $exam_id)->orderBy('ordern', 'asc')->count();
        return $list;
    }
}
