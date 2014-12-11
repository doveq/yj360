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

        if( is_numeric($info['status']) )
           $data = $data->where('status', $info['status']);

        $data = $data->orderBy('id', 'desc');
        
        return $data;
    }

    public function addInfo($info)
    {
        $this->insert($info);
        $this->sycnUserInfo($info['tel'], $info['status']);
    }

    public function getInfo($id)
    {
        return $this->find($id);
    }

    public function getInfoFromTel($tel)
    {
        return $this->where('tel', $tel)->first();
    }

    public function editInfo($id, $info)
    {
        $this->where('id', $id)->update($info);
        $this->sycnUserInfo($info['tel'], $info['status']);
    }

    public function delInfo($id)
    {
        $info = $this->getInfo($id)->toArray();
        $this->where('id', $id)->delete();
        $this->sycnUserInfo($info[0]['tel'], 0);
    }


    /* 检测老师班级和学生总数条件 */
    public function checkTeacher($uid)
    {
        $info['isCheck'] = 1;  // 默认通过
        $info['minMate'] = 15;  // 最少学生数

        $cs = new Classes();
        $cm = new Classmate();
        $us = new User();
        
        $uinfo = $us->getInfoById($uid); // 用户信息

        // 老师类型,教研老师不限制
        // array('1' => '小学', '2' => '中学', '3' => '音基', '4' => '小学教研', '5' => '中学教研', '6' => '少年宫');
        $teacher = $this->getInfoFromTel($uinfo['tel']); // 查找教师对应表数据

        if(empty($teacher) || ($teacher->type != 4 && $teacher->type != 5) )
        {
            $cslist = $cs->getInfo($uid); // 班级列表
            $csnum = $cslist->count();  // 班级数
            $matenum = 0; // 班级学生总数

            // 音基老师只需要5个学生
            if(!empty($teacher) && $teacher->type == 3)
                $info['minMate'] = 5;

            foreach ($cslist as $key => $value) 
            {
                $mate = $cm->getList($value->id);
                $matenum = $matenum + $mate->count();
            }

            // 小于规定的学生数则提示
            if( $matenum < $info['minMate'])
                $info['isCheck'] = 0;
        }

        return $info;
    }


    /** 根据老师表数据，更新用户表用户类型。
        如果教师表有该手机号，则用户表设置改账户为老师
    */
    public function sycnUserInfo($tel, $status)
    {
        if( !empty($tel) )
        {
            $user = new User();
            // 老师
            if($status == 1)
                $user->setInfoFromTel($tel, array('type' => 1) );
            else
                $user->setInfoFromTel($tel, array('type' => 0) ); // 修改为学生
        }
    }

}