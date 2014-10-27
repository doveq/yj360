<?php

class Result extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'result_log';

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
        return $this->belongsTo('Question', 'qid');
    }

    public function del($info)
    {
        $this->where('uid', '=', $info['uid'])->where('id', '=', $info['id'])->delete();
        return 1;
    }


    public function getList($info)
    {
        $list = $this->with('Question')->where('uid', '=', $info['uid'])->where('is_true', '<>', 1)->take($info['limit'])->get();
        return $list;
    }

}
