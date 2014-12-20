<?php

class Student extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'student_info';
    protected $guarded = array('id');
    public $timestamps = false; // 不自动跟新时间

    public function getList($info = array())
    {
        $data = $this;

        if( !empty($info['name']) )
           $data = $data->where('name', 'like', '%' . $info['name'] . '%'); 

        if( !empty($info['teacher']) )
           $data = $data->where('teacher', 'like', '%' . $info['teacher'] . '%'); 

        if( !empty($info['retel']) )
           $data = $data->where('retel', $info['retel']);

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
        // 判断是该手机号是否已添加
        $ndata = $this->getInfoFromTel($info['tel']);
        if( empty($ndata) )
        {
            $this->insert($info);

            // 判断用户表数据
            $user = new User();
            $udata = $user->getInfoByTel( $info['tel'] );

            if( empty($udata) )
            {
                $uinfo = array();
                $uinfo['name'] = $info['name'];
                $uinfo['tel'] = $info['tel'];
                $uinfo['password'] = '123456';  // 默认密码
                $uinfo['type'] = 0;  // 学生
                $uinfo['status'] = 2; // 手机号未验证
                
                // 获取推荐人信息
                if( !empty($info['retel']) )
                {
                    $ud = $user->getInfoByTel( $info['retel'] );
                    if( !empty($ud) )
                    {
                        $uinfo['inviter'] = $ud->id;
                    }
                }

                $user->add($uinfo);
            }

            return 1;
        }
        else
            return -1; // 该手机号已经添加
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
        //$this->sycnUserInfo($info['tel'], $info['status']);
    }

    public function delInfo($id)
    {
        $info = $this->getInfo($id)->toArray();
        $this->where('id', $id)->delete();
        //$this->sycnUserInfo($info[0]['tel'], 0);
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