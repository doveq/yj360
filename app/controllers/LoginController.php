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
			Session::put('utype', $user->type);

			//记录登陆日志
			$loginlog = new Loginlog();
			$loginlog->user_id = $user->id;
			$loginlog->ip = Request::getClientIp();
			$loginlog->created_at = date("Y-m-d H:i:s");
			$loginlog->user_agent = Request::header('user-agent');
			$loginlog->save();

			// echo "登录成功~";
    		return Redirect::to('/');
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
			'name' => 'required|alpha_dash|between:3,8',
	        'tel' => 'required|digits:11|unique:users',
	        'password' => 'required|min:6|confirmed')
		);

		$data['is_certificate'] = 0;
		$data['type'] = 1;

		if( $data['code'] == Session::get('code') )
		{
			if($validator->passes())
			{
				if( isset($_FILES['teacher_img']['error']) 
					&& $_FILES['teacher_img']['error'] == UPLOAD_ERR_OK ) 
				{
					$data['is_certificate'] = 1;
				}

				$user = new User;
				$uid = $user->add($data);

				if($data['is_certificate'] == 1)
				{
					$att = new Attachments();
					$att->addTeacherImg($uid, $_FILES['teacher_img']['tmp_name']);

					$data['type'] = 2;
				}

				return $this->indexPrompt("操作成功", "用户注册成功，请登录", $url = "/login", $auto = true);
			}
		}
		else
		{
			$data['codeErr'] = "验证码错误";
		}

		
		return Redirect::to('register')->withErrors($validator)->withInput(Input::except('teacher_img'));
	}


	/* 退出 */
	public function logout()
	{
		Auth::logout();
		return Redirect::to('/');
	}


	/* 生成发送验证码 */
	public function mkcode()
	{
		$mobile = Input::get('mobile');
		
		if( !is_numeric($mobile) || strlen($mobile) != 11)
			return -1;

		$code = rand(100000, 999999);
		Session::put('code', $code);

		$msg = "验证码：{$code}（为了保证账户安全，请勿向他人泄漏）【音教360】";

		$message = new Message();
		return $message->mobileMsg($mobile, $msg);
	}


	/* 处理ajax */
	public function ajax()
	{
		$inputs = Input::all();
		if($inputs['act'] == 'code')
		{
			$re = $this->mkcode();
			return Response::json(array('act' => $inputs['act'], 'state' => $re));
		}

		return Response::json(array('act' => $inputs['act'], 'state' => '0'));
	}
}
