<?php

class Message extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'message';
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



    public function sender()
    {
        return $this->belongsTo('User', 'sender_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo('User', 'receiver_id', 'id');
    }


}
