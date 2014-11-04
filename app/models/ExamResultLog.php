<?php

class ExamResultLog extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'exam_result_log';
    protected $guarded = array('id');

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
        $this->uid = $info['uid'];
        $this->exam_id = $info['exam_id'];
        $this->question_id = $info['question_id'];
        $this->column_id = $info['column_id'];
        $this->created_at = date('Y-m-d H:i:s');
        $this->uniqid = $info['uniqid'];
        $this->question_id = $info['question_id'];
            
        $this->save();
    }

}