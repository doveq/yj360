<?php

class LoginController extends BaseController 
{

	public function __construct()
    {
    	$this->beforeFilter('csrf', array('on' => 'post'));
    }

	/*  后台登录 */
	public function admin()
	{
		return $this->adminView('login');
	}

	/* 前台登录 */
	public function index()
	{

	}

	/* 登录处理 */ 
	public function doLogin()
	{

	}

	public function doAdminLogin()
	{
		$data = Input::all();

		return $this->adminView('login');
	}

	/* 用户注册 */
	public function register()
	{
		return $this->indexView('register');
	}

	public function doRegister()
	{
		$data = Input::all();
		$validator = Validator::make($data , array(
	        'tel' => 'required|digits:13|unique:users',
	        'password' => 'required|min:6|confirmed')
		);

		if($validator->passes())
		{
			$user = new User;
			$user->add($data);
			echo "ook";
		}
		else
		{
			return Redirect::to('register')->withErrors($validator);
		}
	}


	
}
