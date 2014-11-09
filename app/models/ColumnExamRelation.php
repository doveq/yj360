<?php

class ColumnExamRelation extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'column_exam_relation';
    protected $guarded = array('id');

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = array('password', 'remember_token');


    /* 获取对应的题目列表 */
    public function getList($column_id)
    {
        $info = $this->where('column_id', '=', $column_id)->get();
        if($info)
            return $info->toArray();
        else
            return 0;
    }

    /* 获取随机列表 */
    public function getRandList($column_id, $num)
    {
        $info = $this->where('column_id', '=', $column_id)->orderByRaw("RAND()")->get();
        if($info)
            return $info->toArray();
        else
            return 0;
    }

    public function exam()
    {
        return $this->belongsTo('ExamPaper', 'exam_id');
    }

}