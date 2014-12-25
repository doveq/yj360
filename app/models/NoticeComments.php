<?php

class NoticeComments extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notice_comments';
    
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
    
    public function notice() {
        return $this->belongsTo('Notice', 'notice_id', 'id');
    }
    
    /**
     * 父评论
     */
    public function cite() {
    	return $this->belongsTo('NoticeComments', 'parent_id', 'id');
    }

    public function getList($id)
    {
        return $this->where('notice_id', $id)->orderBy('id', 'desc')->get();
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
    
    /**
     * 根据id批量删除
     */
    public function delInfos($idarr) {
        if(empty($idarr)) {
            return;
        }
        return $this->whereIn('id', $idarr)->delete();
    }

    public function editInfo($id, $info)
    {
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
    
    /**
     * 查看所有评论分页
     * @param $content 要搜索的评论内容
     * @param $pageSize 分页数目
     */
    public function getAllListPage($content, $pageSize) {
        $data = $this;
        if($content != '') {
            $data = $data->where('content', 'like', "%$content%");
        }
        $data = $data->orderBy('id', 'desc')->paginate($pageSize);
        return $data;
    }
    
    /**
     * 根据消息id删除所有相关评论
     */
    public function delByNotice($notice_id) {
        return $this->where('notice_id', $notice_id)->delete();
    }
}