<?php

class Topic  {

	
	/* 添加题目 */
	public function add($data)
	{
		$info = array();
		
		if(isset($data['txt']) && !empty($data['txt']))
			$info['txt'] = $data['txt'];

		if(isset($data['sound']) && is_numeric($data['sound']))
			$info['sound'] = $data['sound'];

		if(isset($data['img']) && is_numeric($data['img']))
			$info['img'] = $data['img'];

		if(isset($data['video']) && is_numeric($data['video']))
			$info['video'] = $data['video'];

		if(isset($data['disabuse']) && !empty($data['disabuse']))
			$info['disabuse'] = $data['disabuse'];

		if(isset($data['type']) && is_numeric($data['type']))
				$info['type'] = $data['type'];
	
		$info['created_at'] = date('Y-m-d H:i:s');
		$id = DB::table("questions")->insertGetId($info);

    	return $id;
	}

	/* 加密用户密码 */
	public function encPasswd($password)
	{
		return md5(md5($password) . $password);
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

		if( is_numeric($data['tel']) )
		{
			$whereArr[] = " `tel` = ? ";
			$valueArr[] = $data['tel'];
		}

		if( is_numeric($data['type']) )
		{
			$whereArr[] = " `type` = ? ";
			$valueArr[] = $data['type'];
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
