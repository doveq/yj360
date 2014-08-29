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
		$users = User::all();
		return $users;
	}

	/* 单个用户信息 */
	public function getInfo($data)
	{
		
	}
}
