<?php

class Favorite extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'favorite';
    public $timestamps = false; // 不自动跟新时间

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = array('password', 'remember_token');

    
    public function question()
    {
        return $this->belongsTo('Question');
    }

    public function add($info)
    {
        $count = $this->where('uid', '=', $info['uid'])->where('question_id', '=', $info['qid'])->where('column_id', '=', $info['column_id'])->count();

        if(!$count)
        {
            $this->uid = $info['uid'];
            $this->question_id = $info['qid'];
            $this->column_id = $info['column_id'];
            $this->sort = $info['sort'];
            $this->created_at = date('Y-m-d H:i:s');
            $this->save();
        } else {
        	// 如果已添加过,修改sort值
        	$this->where('uid', '=', $info['uid'])->where('question_id', '=', $info['qid'])
        		 ->where('column_id', '=', $info['column_id'])
        		 ->update(array('sort'=>$info['sort'], 'created_at'=>date('Y-m-d H:i:s')));
        }

        return 1;
    }

    public function del($info)
    {
        $this->where('uid', '=', $info['uid'])->where('question_id', '=', $info['qid'])->delete();
        return 1;
    }
    
    public function getList($info)
    {
        $list = $this->where('uid', '=', $info['uid']);

        if(is_numeric($info['sort'])) {
        	if($info['sort'] == 0) {
        		// 默认分类sort为null或0
        		$list = $list->where('sort', '=', '0');
        	} else {
            	$list = $list->where('sort', '=', $info['sort']);
        	}
        }
        
//         if(is_numeric($info['column_id']))
//         {
//             // 获取所有子分类id
//             $c = new Column();
//             $carr = $c->allchild($info['column_id']);
//             $list = $list->whereIn('column_id', $carr);
//         }
//         if(is_numeric($info['limit']))
//             $list = $list->take($info['limit']);

        return $list->paginate($info['limit']);
    }
    
    /**
     * 获取栏目下收藏总条数
     */
    public function getFavCount($uid, $column_id) {
    	if(empty($column_id) || !is_numeric($column_id)) {
    		return 0;
    	}
    	return $this->where('uid', '=', $uid)->count();
    }
    
    public function delByIds($uid, $idarr) {
    	$this->where('uid', '=', $uid)->whereIn('id', $idarr)->delete();
    	return 1;
    }
    
    /**
     * 修改分类
     * @param int $sort 分类id
     */
    public function updateSort($uid, $idarr, $sortid) {
    	if(empty($idarr) || empty($sortid)) {
    		return 0;
    	}
    	$this->where('uid', '=', $uid)->whereIn('id', $idarr)->update(array('sort'=>$sortid));
    	return 1;
    }
    
    /**
     * 删除收藏分类时设置sort为默认分类
     */
    public function updateDefaultSort($uid, $sortid) {
    	if(empty($sortid)) {
    		return 0;
    	}
    	$this->where('uid', '=', $uid)->where('sort', '=', $sortid)->update(array('sort'=>0));
    	return 1;
    }
}
