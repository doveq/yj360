<?php

/**
 * 班级公告与用户关系表
 */
class ClassesNoticeUser extends Eloquent {
    protected $table = 'class_notice_user';
    
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
     * 根据公告id删除相关记录
     * @param int $notice_id 公告id
     */
    public function delByNotice($notice_id) {
        return $this->where('notice_id', $notice_id)->delete();
    }
}