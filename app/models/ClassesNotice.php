<?php

/**
 * 班级消息
 */
class ClassesNotice extends Eloquent {
    protected $table = 'class_notice';

    public function user() {
        return $this->belongsTo('User', 'uid', 'id');
    }
    
    public function classes() {
    	return $this->belongsTo('Classes', 'class_id', 'id');
    }

    public function getListPage($info = array(), $pageSize) {
        return $this
        	->where('class_id', '=', $info['class_id'])
        	->orderBy('id', 'desc')
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
}