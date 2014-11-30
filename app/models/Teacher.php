<?php

class Teacher extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'teacher_info';
    protected $guarded = array('id');
    public $timestamps = false; // 不自动跟新时间

    public function getList($info = array())
    {
        $data = $this;

        if( !empty($info['name']) )
           $data = $data->where('name', 'like', '%' . $info['name'] . '%'); 

        if( !empty($info['tel']) )
           $data = $data->where('tel', $info['tel']);

        if( !empty($info['type']) )
           $data = $data->where('type', $info['type']);

        $data = $data->orderBy('id', 'desc');
        
        return $data;
    }

    public function addInfo($info)
    {
        $this->insert($info);
    }

    public function getInfo($id)
    {
        return $this->find($id);
    }

    public function editInfo($id, $info)
    {
        return $this->where('id', $id)->update($info);
    }

    public function delInfo($id)
    {
        return $this->where('id', $id)->delete();
    }
}