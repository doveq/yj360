<?php

class Classmate extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'classmate';
    protected $guarded = array('id');

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
    //

    public function classes()
    {
        return $this->belongsTo('Classes', 'class_id','id');
    }

    public function student()
    {
        return $this->belongsTo('User', 'user_id','id');
    }

    public function teacher()
    {
        return $this->belongsTo('User', 'teacher_id','id');
    }

    public function log()
    {
        return $this->hasOne('ClassmateLog', 'classmate_id', 'id');
    }

    /* 获取班级学生列表 */
    public function getList($id)
    {
        return $this->where('class_id', $id)->get();
    }

}
