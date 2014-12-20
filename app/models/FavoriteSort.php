<?php

class FavoriteSort extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'favorite_sort';
    public $timestamps = false; // 不自动跟新时间

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = array('password', 'remember_token');


    public function addInfo($info)
    {
        return $this->insert($info);
    }

    public function editInfo($info)
    {
        $data = array();
        $data['name'] = $info['name'];
        return $this->where('id', $info['id'])->where('uid', $info['uid'])->update( $data );
    }

    public function delInfo($info)
    {
        return $this->where('id', $info['id'])->where('uid', $info['uid'])->delete();
    }

    public function getList($info)
    {
        return $this->where('uid', $info['uid'])->get();
    }
    
    public function getListPage($info, $pageSize) {
    	return $this->where('uid', $info['uid'])->paginate($pageSize);
    }
}
