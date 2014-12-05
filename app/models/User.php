<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');


	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	// public function getRememberToken()
	// {
	//     return $this->remember_token;
	// }

	// public function setRememberToken($value)
	// {
	//     $this->remember_token = $value;
	// }

	// public function getRememberTokenName()
	// {
	//     return 'remember_token';
	// }

	/* 添加用户 */
	public function add($data)
	{

		 $info = array(
				'name' =>  $data['name'],
    			'tel' => $data['tel'],
    			'password' => $this->encPasswd($data['password']),
    			'is_certificate' => $data['is_certificate'],
    			'type' => $data['type'],
    			'created_at' => date('Y-m-d H:i:s'),
    			'status' => 1,
    		);

		 if(!empty($data['inviter']) && is_numeric($data['inviter']))
		 	$info['inviter'] = $data['inviter'];


		$id = DB::table($this->table)->insertGetId($info);

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

	public function setInfoFromTel($tel, $data)
	{
		DB::table($this->table)->where('tel', $tel)->update($data);
	}

	public function del($id)
	{
		DB::table($this->table)->where('id', $id)->delete();
	}

	public function sender()
	{
		return $this->hasMany('Message', 'sender_id');
	}

	public function receiver()
	{
		return $this->hasMany('Message', 'receiver_id');
	}

	public function products()
	{
        return $this->belongsToMany('Product', 'myproduct');
	}

	public function classes()
	{
        return $this->hasMany('Classes', 'teacherid');
	}

	public function classeses()
	{
        return $this->belongsToMany('Classes', 'classmate', 'user_id', 'class_id');
	}

	public function feedbacks()
	{
        return $this->hasMany('feedback');
	}

	public function favorites()
    {
        return $this->belongsToMany('Question', 'favorite', 'id', 'question_id');
    }

    public function trainings()
	{
        return $this->hasMany('Training', 'user_id');
	}
	
}
