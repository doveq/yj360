<?php

class Favorite extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'favorite';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = array('password', 'remember_token');


    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    // public function getAuthIdentifier()
    // {
    //  return $this->getKey();
    // }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    // public function getAuthPassword()
    // {
    //  return $this->password;
    // }



    // public function user()
    // {
    //     return $this->belongsTo('User');
    // }

    
    public function question()
    {
        return $this->belongsTo('Question');
    }

    public function add($info)
    {
        $count = $this->where('user_id', '=', $info['uid'])->where('question_id', '=', $info['qid'])->count();

        if(!$count)
        {
            $this->user_id = $info['uid'];
            $this->question_id = $info['qid'];
            $this->save();
        }

        return 1;
    }

    public function del($info)
    {
        $this->where('user_id', '=', $info['uid'])->where('question_id', '=', $info['qid'])->delete();
        return 1;
    }


    public function getList($info)
    {
        $list = $this->where('user_id', '=', $info['uid'])->take($info['limit'])->get();
        return $list;
    }
}
