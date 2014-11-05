<?php

class FailTopic extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fail_topic';
    public $timestamps = false; // 不自动跟新时间

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = array('password', 'remember_token');

    
    public function question()
    {
        return $this->belongsTo('Question', 'question_id');
    }

    public function add($info)
    {
        $this->uid = $info['uid'];
        $this->question_id = $info['question_id'];
        $this->column_id = $info['column_id'];
        $this->created_at = date('Y-m-d H:i:s');
        $this->save();
    }

    public function del($info)
    {
        $this->where('id', '=', $info['id'])->where('uid', '=', $info['uid'])->delete();
        return 1;
    }


    public function getList($info)
    {
        if(empty($info['column_id']))
        {
            $list = $this->with('Question')->where('uid', '=', $info['uid'])->take($info['limit'])->get();
            return $list;
        }
        else
        {
            // 获取所有子分类id
            $c = new Column();
            $carr = $c->allchild($info['column_id']);

            $list = $this->with('Question')->where('uid', '=', $info['uid'])->whereIn('column_id', $carr)->take($info['limit'])->get();
            return $list;
        }
    }

}
