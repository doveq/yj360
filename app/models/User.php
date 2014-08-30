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
		$user = new User();
		$user->name = $data['name'];
		$user->tel = $data['tel'];
		$user->password = $this->encPasswd($data['password']);
		$user->save();
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

		$where = '';
		if($whereArr)
			$where = ' where ' . implode(' and ', $whereArr);

		$sql = "select * from {$this->table} {$where} order by id desc";
		$results = DB::select($sql, $valueArr);
		#print_r(DB::getQueryLog());

		foreach($results as &$item)
		{
			$item = (array)$item;
		}
		
		return $results;
	}

	/* 查找单个用户信息 */
	public function getInfoById($id)
	{
		return User::find($id)->toArray();
	}

	/* 跟新用户信息 */
	public function setInfo($id, $data)
	{ 
		$affectedRows = User::where('id', '=', $id)->update($data);
		return $affectedRows;
	}
}
