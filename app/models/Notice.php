<?php

class Notice extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notice';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = array('password', 'remember_token');


    public function user()
    {
        return $this->belongsTo('User', 'uid', 'id');
    }

    public function getList($info = array())
    {
        $db = $this;
        if(!empty($info['type']))
            $db = $db->where('type', $info['type']);

        if(!empty($info['status']))
            $db = $db->where('status', $info['status']);

        if(!empty($info['allow']))
        {
            $in = array(0, $info['allow']);
            $db = $db->whereIn('allow', $in);
        }

        if(!empty($info['title']))
            $db = $db->where('title', 'like', '%' . $info['title'] . '%');

        return $db->orderBy('ordern', 'asc')->paginate($info['pageSize']);
    }

    public function addInfo($info)
    {
        $info['created_at'] = date('Y-m-d H:i:s');
        $this->insert($info);
    }

    public function getInfo($id)
    {
        return $this->find($id);
    }

    public function delInfo($id)
    {
        return $this->find($id)->delete();
    }

    public function editInfo($id, $info)
    {
        return $this->where('id', $id)->update($info);
    }
    
    /**
     * 获取评论数量
     */
    public function commentcount() {
    	return $this->hasMany('NoticeComments', 'notice_id', 'id');
    }
}