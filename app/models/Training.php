<?php

class Training extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'training';

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


    public function questions()
    {
        return $this->belongsToMany('Question', 'training_question_relation', 'training_id', 'question_id');
    }

    public function teacher()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function student()
    {
        return $this->belongsToMany('User', 'training_result', 'training_id', 'user_id');
    }
}
