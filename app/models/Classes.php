<?php

class Classes extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'class';

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



    public function students()
    {
        return $this->belongsToMany('User', 'classmate', 'class_id', 'user_id')->withPivot('id', 'status', 'created_at');
    }

    public function teacher()
    {
        return $this->belongsTo('User', 'teacherid','id');
    }

    public function creater()
    {
        return $this->belongsTo('User', 'creater','id');
    }
}
