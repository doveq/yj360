<?php

/**
 * 问题反馈与用户关系表
 */
class FeedbackUser extends Eloquent {
    protected $table = 'feedback_user';
    
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
        $info['created_at'] = date('Y-m-d H:i:s');
        return $this->where('id', $id)->update($info);
    }
    
    /**
     * 标记回复为已读
     * @param array $reply_ids 回复id列表
     */
    public static function readreplys($uid, $reply_ids) {
        if(empty($reply_ids)) {
            return;
        }
        $fbu = new FeedbackUser();
        $read_ids = $fbu->where('uid', $uid)->lists('feedback_id'); // 已读回复id列表
        $unread_ids = array_diff($reply_ids, $read_ids); // 未读回复id列表
        if(empty($unread_ids)) {
            return;
        }

        $records = array();
        $created_at = date('Y-m-d H:i:s');
        foreach($unread_ids as $unread_id) {
            $records[] = array('feedback_id'=>$unread_id, 'uid'=>$uid, 'created_at'=>$created_at);
        }
        $fbu->insert($records);
    }
    
    /**
     * 查询未读回复数
     */
    public static function unreadreplycount($uid) {
        $fb = new Feedback();
        $fbids = $fb->where('user_id', $uid)->where('reply', '!=', '')->lists('id'); // 回复id列表
        $total = count($fbids); // 回复总数
        if($total == 0) {
            return 0;
        }
        $fbu = new FeedbackUser();
        $reads = $fbu->where('uid', $uid)->whereIn('feedback_id', $fbids)->count(); // 已读回复数
        if($total > 0 && $total > $reads) {
            return $total-$reads;
        } else {
            return 0;
        }
    }
}