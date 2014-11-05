<?php

class Favorite extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'favorite';
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

    public function add($info)
    {
        $count = $this->where('uid', '=', $info['uid'])->where('question_id', '=', $info['qid'])->where('column_id', '=', $info['column_id'])->count();

        if(!$count)
        {
            $this->uid = $info['uid'];
            $this->question_id = $info['qid'];
            $this->column_id = $info['column_id'];
            $this->created_at = date('Y-m-d H:i:s');
            $this->save();
        }

        return 1;
    }

    public function del($info)
    {
        $this->where('uid', '=', $info['uid'])->where('question_id', '=', $info['qid'])->where('column_id', '=', $info['column_id'])->delete();
        return 1;
    }


    public function getList($info)
    {

        if(empty($info['column_id']))
        {
            $list = $this->where('uid', '=', $info['uid'])->take($info['limit'])->get();
            return $list;
        }
        else
        {
            // 获取所有子分类id
            $c = new Column();
            $carr = $c->allchild($info['column_id']);

            $list = $this->where('uid', '=', $info['uid'])->whereIn('column_id', $carr)->take($info['limit'])->get();
            return $list;
        }
        
    }
}
