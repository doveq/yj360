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

		// Auth::attempt( array('name' => $data['name'], 'password' => $data['password'], 'status' => 1))
		if( Auth::attempt( array('tel' => trim($data['name']), 'password' => $data['password'], 'status' => 1)) )
		{
			//login(UserInterface $user, bool $remember = false);
			$user = Auth::user();
			Auth::login( $user );
			Session::put('uid', $user->id);
			Session::put('uname', $user->name);
			Session::put('utype', $user->type);
			Session::put('utel', $user->tel);

			//记录登陆日志
			$loginlog = new Loginlog();
			$loginlog->user_id = $user->id;
			$loginlog->ip = Request::getClientIp();
			$loginlog->created_at = date("Y-m-d H:i:s");
			$loginlog->user_agent = Request::header('user-agent');
			$loginlog->save();

			// echo "登录成功~";
    		//return Redirect::to('/');
    		return Redirect::to('/column/static');
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
			Session::put('utype', $user->type);
			Session::put('utel', $user->tel);

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
		$inviter = Session::get('inviter');
		if ($inviter == '') {
			return Redirect::to('/invite_by');
		}
		return $this->indexView('register', compact('inviter'));
	}

	public function doRegister()
	{
		$data = Input::all();
		$validator = Validator::make($data , array(
			'name' => 'required|alpha_dash|between:2,8',
	        'tel' => 'required|digits:11|unique:users',
	        'password' => 'required|min:6|confirmed',
	        'inviter' => 'numeric')
		);

		$data['is_certificate'] = 0;
		$data['type'] = 0; // 默认为学生


		if($data['code'] == Session::get('code') )
		{
			if($validator->passes())
			{
				if( isset($_FILES['teacher_img']['error'])
					&& $_FILES['teacher_img']['error'] == UPLOAD_ERR_OK )
				{
					$data['is_certificate'] = 1;
				}

				// 如果这个手机在老师信息表则类型修改为老师
				$results = DB::select('select * from teacher_info where tel = ?', array($data['tel']));
				if(!empty($results[0]))
				{
					$data['type'] = 1;
				}

				$user = new User;
				$uid = $user->add($data);

				if($data['is_certificate'] == 1)
				{
					$att = new Attachments();
					$att->addTeacherImg($uid, $_FILES['teacher_img']['tmp_name']);

					//$data['type'] = 2;
				}
				//删除session中的邀请人
				// Session::forget('inviter');
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
		Session::flush();
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
		Session::put('mobile', $mobile);

		$msg = "验证码：{$code}（为了保证账户安全，请勿向他人泄漏）【音基360】";

		$message = new Message();
		return $message->mobileMsg($mobile, $msg);
	}


	/* 处理ajax */
	public function ajax()
	{
		$inputs = Input::all();
		// 手机验证码
		if($inputs['act'] == 'code')
		{
			$re = $this->mkcode();
			return Response::json(array('act' => $inputs['act'], 'state' => $re));
		}
		// 重设密码
		elseif($inputs['act'] == 'forgot')
		{
			$user = new User;
			$info = $user->where('tel', '=', $inputs['mobile'])->first();
			if( !empty($info) )
			{
				$passwd = rand(100000, 999999);

				$user->setInfo($info->id, array('password' => $user->encPasswd($passwd)) );

				$msg = "新密码：{$passwd}（为了保证账户安全，请勿向他人泄漏）【音基360】";

				$message = new Message();
				$message->mobileMsg($inputs['mobile'], $msg);
				return Response::json(array('act' => $inputs['act'], 'state' => 1));
			}
			else
			{
				return Response::json(array('act' => $inputs['act'], 'state' => 0, 'info' => '该手机号没有注册'));
			}
		}

		return Response::json(array('act' => $inputs['act'], 'state' => '0'));
	}

	/* 找回密码页 */
	public function forgot()
	{
		//$mobile = Input::get('mobile');

		return $this->indexView('forgot');
	}

	public function doForgot()
	{
		$data = Input::all();

		$validator = Validator::make($data , array(
	        'tel' => 'required|digits:11',
	        'password' => 'required|min:6|confirmed')
		);

		if($data['code'] == Session::get('code') && $data['tel'] == Session::get('mobile') )
		{
			if($validator->passes())
			{
				$user = new User;
				$info = $user->where('tel', '=', $data['tel'])->first();
				if( !empty($info) )
				{
					$user->setInfo($info->id, array('password' => $user->encPasswd($data['password'])) );
					return $this->indexPrompt("操作成功", "密码重置成功，请登录", $url = "/login", $auto = true);
				}
				else
				{
					return $this->indexPrompt("", "该手机没有注册，请重试", $url = "/forgot", $auto = true);
				}
			}
		}
		else
		{
			$data['codeErr'] = "验证码错误";
		}

		return Redirect::to('forgot')->withErrors($validator)->withInput($data);
	}

	/* 填写邀请人 */
	public function inviteby()
	{

		return $this->indexView('inviteby');
	}
	/* 填写邀请人 */
	public function doinviteby()
	{
		$query = Input::only('name');
        $validator = Validator::make($query,
            array(
                'name' => 'required',
            )
        );

        if($validator->fails())
        {
            return Redirect::to('/invite_by')->withErrors($validator)->withInput($query);
        }
        $info = User::whereName($query['name'])->first();
        if ($info) {
        	Session::flash('inviter', $info->id);
			return Redirect::to('/register');
        } else {
        	$error = '没有此人';
			return $this->indexView('inviteby', compact('error'));
        }
		// return $this->indexView('inviteby');
	}
}
