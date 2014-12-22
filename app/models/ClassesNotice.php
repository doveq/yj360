<?php

/**
 * 班级消息
 */
class ClassesNotice extends Eloquent {
    protected $table = 'class_notice';
    
    /**
     * 是否启用ordern排序
     */
    protected $use_ordern = true;

    public function user() {
        return $this->belongsTo('User', 'uid', 'id');
    }
    
    public function classes() {
    	return $this->belongsTo('Classes', 'class_id', 'id');
    }

    public function getListPage($info = array(), $pageSize) {
        if($this->use_ordern) {
            $ordername = 'ordern';
            $ordertype = 'asc';
        } else {
            $ordername = 'id';
            $ordertype = 'desc';
        }
        return $this
        	->where('class_id', '=', $info['class_id'])
        	->orderBy($ordername, $ordertype)
        	->paginate($pageSize);
    }

    public function addInfo($info) {
        $info['created_at'] = date('Y-m-d H:i:s');
        return $this->insertGetId($info);
    }

    public function getInfo($id) {
        return $this->find($id);
    }

    public function delInfo($id) {
        return $this->find($id)->delete();
    }

    public function editInfo($id, $info) {
    	$info['updated_at'] = date('Y-m-d H:i:s');
        return $this->where('id', $id)->update($info);
    }
    
    /**
     * 获取评论数量
     */
    public function commentcount() {
    	return $this->hasMany('ClassesNoticeComments', 'notice_id', 'id');
    }
    
    /**
     * 计算页面浏览量
     */
    public function computeVisits($page_id, $ip) {
        // 在ip_page中class_notice表的type为1
        $page_type = 1;
        
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