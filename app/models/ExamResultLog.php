<?php

class ExamResultLog extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'exam_result_log';
    protected $guarded = array('id');
    public $timestamps = false; // 不自动跟新时间

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = array('password', 'remember_token');

    public function question()
    {
        return $this->belongsTo('Question');
    }


    /* 添加试卷信息到做题记录 
        $info 试卷信息
        $list 题目列表
    */
    public function add($info)
    {
        $now = date('Y-m-d H:i:s');
        foreach ($info['list'] as $key => $qid) 
        {
            $data = array();
            $data['created_at'] = $now;
            $data['uniqid'] = $info['uniqid'];
            $data['column_id'] = $info['column_id'];
            $data['exam_id'] = $info['exam_id'];
            $data['uid'] = $info['uid'];
            $data['question_id'] = $qid;

            if(isset($info['trues'][$qid]))
                $data['is_true'] = $info['trues'][$qid];

            if(isset($info['answers'][$qid]))
                $data['answers'] = $info['answers'][$qid];

            DB::table("exam_result_log")->insert($data);
        }
    }


    public function getList($uniqid)
    {
        $info = DB::table('exam_result_log')->where('uniqid', $uniqid)->orderBy('id', 'ASC')->get();
        foreach($info as &$item)
        {
            $item = (array)$item;
        }

        return (array)$info;
    }

}