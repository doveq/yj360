<?php

class Classes extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'class';
    // protected $guarded = array('id');

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

    public function classmates()
    {
        return $this->hasMany('Classmate', 'class_id', 'id');
    }

    public function creater()
    {
        return $this->belongsTo('User', 'creater','id');
    }

    public function column()
    {
        return $this->belongsTo('Column');
    }

    public function trainings()
    {
        return $this->hasMany('Training');
    }

    /* 获取老师班级信息 */
    public function getInfo($uid)
    {
        return $this->where('teacherid', $uid)->get();
    }
    
    /**
     * 编辑班级信息
     */
    public function editInfo($info) {
    	$data = array();
    	$data['name'] = $info['name'];
    	return $this->where('id', $info['id'])->where('teacherid', $info['uid'])->update($data);
    }
    
    /**
     * 删除班级
     */
    public function delInfo($info) {
    	return $this->where('id', $info['id'])->where('teacherid', $info['uid'])->delete();
    }
    
    /**
     * 班级消息数目
     */
    public function noticescount() {
        return $this->hasMany('ClassesNotice', 'class_id', 'id')->count();
    }
}
