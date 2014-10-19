<?php

class LoginController extends BaseController
{

	public function __construct()
    {
    	//$this->beforeFilter('csrf', array('on' => 'post'));
    }

	/*  后台登录 */
	public function admin()
	{
		$data['message'] = Session::get('message');
		return $this->adminView('login', $data);
	}

	/* 前台登录 */
	public function index()
	{
		$data['message'] = Session::get('message');
		return $this->indexView('login', $data);
	}

	/* 登录处理 */
	public function doLogin()
	{
		$data = Input::all();
		if(Auth::attempt( array('name' => $data['name'], 'password' => $data['password'], 'status' => 1)))
		{
			//login(UserInterface $user, bool $remember = false);
			$user = Auth::user();
			Auth::login( $user );
			Session::put('uid', $user->id);
			Session::put('uname', $user->name);

			//记录登陆日志
			$loginlog = new Loginlog();
			$loginlog->user_id = $user->id;
			$loginlog->ip = Request::getClientIp();
			$loginlog->created_at = date("Y-m-d H:i:s");
			$loginlog->user_agent = Request::header('user-agent');
			$loginlog->save();

			echo "登录成功~";
    		//return Redirect::to('/');
		}
		else
			return Redirect::to('login')->with('message', '登录失败')->withInput($data);
	}

	public function doAdminLogin()
	{
		$data = Input::all();
		if(Auth::attempt( array('name' => $data['name'], 'password' => $data['password'], 'type' => -1, 'status' => 1)))
		{
			//login(UserInterface $user, bool $remember = false);
			$user = Auth::user();
			Auth::login( $user );
			Session::put('uid', $user->id);
			Session::put('uname', $user->name);

			//记录登陆日志
			$loginlog = new Loginlog();
			$loginlog->user_id = $user->id;
			$loginlog->ip = Request::getClientIp();
			$loginlog->created_at = date("Y-m-d H:i:s");
			$loginlog->user_agent = Request::header('user-agent');
			$loginlog->save();

    		return Redirect::to('admin');
		}
		else
			return Redirect::to('admin/login')->with('message', '登录失败');
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
			'name' => 'required|alpha_dash|between:4,12|unique:users',
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
			return Redirect::to('register')->withErrors($validator)->withInput($data);
		}
	}


	/* 退出 */
	public function logout()
	{
		Auth::logout();
		return Redirect::to('/');
	}
}
