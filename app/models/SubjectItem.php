<?php

class SubjectItem extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subject_item';

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
            array(
                'name'        => $data['name'],
                'created_at'  => $data['created_at'],
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

    public function contents()
    {
        return $this->hasMany('subject_content');
    }

}
