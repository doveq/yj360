<?php

/**
 * 班级消息评论
 */
class ClassesNoticeComments extends Eloquent {
    protected $table = 'class_notice_comments';

    public function user() {
    	return $this->belongsTo('User', 'uid', 'id');
    }
    
    /**
     * 父评论
     */
    public function cite() {
    	return $this->belongsTo('ClassesNoticeComments', 'parent_id', 'id');
    }
    
    public function getList($id) {
        return $this->where('notice_id', $id)->orderBy('id', 'desc')->get();
    }
    
    public function addInfo($info) {
        $info['created_at'] = date('Y-m-d H:i:s');
        $this->insert($info);
    }

    public function getInfo($id) {
        return $this->find($id);
    }

    public function delInfo($id) {
        return $this->find($id)->delete();
    }

    public function editInfo($id, $info) {
        return $this->where('id', $id)->update($info);
    }
    
    /**
     * 查询评论楼层列表
     */
    public function getFloornums($noticeId) {
    	$records = $this->where('notice_id', $noticeId)->orderBy('id', 'desc')->select('id')->get();
    	$count = count($records);
    	$floornums = [];
    	foreach($records as $k=>$record) {
    		$floornums[$record->id] = $count-$k;
    	}
    	return $floornums;
    }
    
    /**
     * 评论分页查询
     */
    public function getListPage($id, $pageSize) {
    	return $this->where('notice_id', $id)->orderBy('id', 'desc')->paginate($pageSize);
    }
}