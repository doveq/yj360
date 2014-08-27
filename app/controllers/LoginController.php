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
	public function doLogin($data)
	{

	}

	public function doAdminLogin()
	{
		$result = $this->doLogin(Input::all());
		return $this->adminView('login');
	}

	/* 用户注册 */
	public function register()
	{
		return $this->indexView('register');
	}

	public function doRegister()
	{
		return $this->indexView('register');
	}
}
