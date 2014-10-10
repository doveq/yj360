<?php

class Product extends Eloquent {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = array('password', 'remember_token');


    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    // public function getAuthIdentifier()
    // {
    //  return $this->getKey();
    // }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    // public function getAuthPassword()
    // {
    //  return $this->password;
    // }

    /* 添加用户 */
    public function add($data)
    {
        $id = DB::table($this->table)->insertGetId(
            // array(
            //     'name'        => "'" . $data['name'] . "'",
            //     'description' => "'" . $data['desc'] . "'",
            //     // 'online_at'   => "'" . $data['online_at'] . "'",
            //     // 'created_at'  => "'" . $data['created_at'] . "'",
            //     'status'      => $data['status'],
            // )
            array(
                'name'        => $data['name'],
                'description' => $data['desc'],
                'online_at'   => $data['online_at'],
                'created_at'  => $data['created_at'],
                'status'      => $data['status'],
            )

        );

        return $id;
    }

    /* 用户列表 */
    public function getList($data = array())
    {
        $whereArr = array();
        $valueArr = array();
        if( $data['name'] )
        {
            $whereArr[] = " `name` like ? ";
            $valueArr[] = '%'. $data['name'] .'%';
        }

        if( $data['subject_id'] )
        {
            $whereArr[] = " `subject_id` = ? ";
            $valueArr[] = $data['subject_id'];
        }

        if( is_numeric($data['status']) )
        {
            $whereArr[] = " `status` = ? ";
            $valueArr[] = $data['status'];
        }

        $limit = "";
        if( is_numeric($data['page']) && is_numeric($data['pageSize']) )
        {
            $num = $data['pageSize'] * ($data['page'] -1);
            $limit = " limit {$num},{$data['pageSize']} ";
        }

        $where = '';
        if($whereArr)
            $where = ' where ' . implode(' and ', $whereArr);

        $sql = "select * from {$this->table} {$where} order by id desc {$limit} ";
        $results = DB::select($sql, $valueArr);
        #print_r(DB::getQueryLog());

        // 获取总数分页使用
        $sql = "select count(*) as num from {$this->table} {$where}";
        $re2 = DB::select($sql, $valueArr);
        $count = $re2[0]->num;

        foreach($results as &$item)
        {
            $item = (array)$item;
        }

        return array('data' => $results, 'total' => $count);
    }

    /* 查找单个用户信息 */
    public function getInfoById($id)
    {
        $re = DB::table($this->table)->where('id', $id)->get();
        return (array)$re[0];
    }

    /* 跟新用户信息 */
    public function setInfo($id, $data)
    {
        DB::table($this->table)->where('id', $id)->update($data);
    }

    public function del($id)
    {
        DB::table($this->table)->where('id', $id)->delete();
    }


}
