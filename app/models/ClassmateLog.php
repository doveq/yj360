<?php

class ClassmateLog extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'classmate_log';
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

    public function classmate()
    {
        return $this->belongsTo('Classmate', 'classmate_id','id');
    }

}
