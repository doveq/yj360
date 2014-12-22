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
    
    /**
     * 计算页面浏览量
     */
    public function computeVisits($page_id, $ip) {
        // 在ip_page中notice表的type为0
        $page_type = 0;
        
        $data = $this->where('id', $page_id)->first()->toArray();
        if(empty($data)) {
            return 0;
        }
        
        $ip_model = new IpPage();
        $ip_info = $ip_model->where('type', $page_type)->where('ip', $ip)->where('page_id', $page_id)->first();
        if(empty($ip_info)) {
            // 未找到添加记录并修改访问量
            $ip_data = array();
            $ip_data['type'] = $page_type;
            $ip_data['page_id'] = $page_id;
            $ip_data['ip'] = $ip;
            $ip_data['created_at'] = date('Y-m-d H:i:s');
            $ip_model->insert($ip_data);
            
            if(empty($data['visits'])) {
                $data['visits'] = 1;
            } else {
                $data['visits'] = $data['visits'] + 1;
            }
            $this->where('id', $page_id)->update($data);
            return $data['visits'];
        } else {
            // 找到的话直接返回
            $ip_data = $ip_info->toArray();
            $ip_data['updated_at'] = date('Y-m-d H:i:s');
            $ip_model->where('id', $ip_data['id'])->update($ip_data);
            
            return $data['visits'];
        }
    }
}

