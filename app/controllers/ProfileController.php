<?php

class ProfileController extends BaseController {

	public function index()
	{
		$user = new User();
		$info = $user->getInfoById(Session::get('uid'));
		if($info['type'] == 1)
		{
			$info['type_str'] = '老师';
		}
		else if($info['type'] == -1)
		{
			$info['type_str'] = '管理员';
		}
		else if($info['type'] == 0)
		{
			$info['type_str'] = '学生';
		}


		return $this->indexView('profile.index', $info);
	}

	public function showPasswd()
	{
		return $this->indexView('profile.passwd');
	}

	public function doProfile()
	{
		$inputs = Input::all();

		$user = new User();

		$update = array();

		
		$validator = Validator::make($inputs , array(
	        'email' => 'email')
		);

		if( !$validator->fails())
		{
			$update['email'] = $inputs['email'];
		}

		if(!empty($inputs['name']))
			$update['name'] = $inputs['name'];
		
		if(is_numeric($inputs['qq']))
			$update['qq'] = $inputs['qq'];

		if(!empty($inputs['company']))
			$update['company'] = $inputs['company'];

		if(!empty($inputs['intro']))
			$update['intro'] = $inputs['intro'];

		if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK )
		{
			$att = new Attachments();
			$re = $att->addAvatar(Session::get('uid'), $_FILES['avatar']['tmp_name']);
			if($re)
				$update['is_avatar'] = 1;
		}

		if($update)
		{
			$user->setInfo(Session::get('uid'), $update);
		}

		return $this->indexPrompt("", '个人资料修改完成', $url = "/profile");
	}


	public function doPasswd()
	{
		$inputs = Input::all();
		
		$user = new User();
		$info = $user->getInfoById(Session::get('uid'));

		if( $info['password'] == $user->encPasswd( $inputs['password'] )  
			&& !empty($inputs['new_password']) 
			&& $inputs['new_password'] === $inputs['password_confirmation'] )
		{
			$update['password'] = $user->encPasswd( $inputs['new_password'] );

			$user->setInfo(Session::get('uid'), $update);

			return $this->indexPrompt("", '密码修改成功', $url = "/profile");
		}

		return $this->indexPrompt("", '密码修改失败，请返回重试', $url = "/profile/passwd", false);		
	}

	/* 显示升级教师页面 */
	public function up()
	{
		$user = new User();
		$uinfo = $user->getInfoById( Session::get('uid') );

		$teacher = new Teacher();
		$tinfo = $teacher->getInfoFromTel($uinfo['tel']);

		$att = new Attachments();
		$route = $att->getTeacherRoute( Session::get('uid') );
		if(is_file($route['path']) )
		{
			$uinfo['img'] = $route['url'];
		}

		$statusEnum = array('1' => '审核通过', '-1' => '审核未通过', '0' => '未审核');

		return $this->indexView('profile.up', compact('tinfo', 'uinfo', 'statusEnum') );
	}

	public function doUp()
	{
		$inputs = Input::all();

		$validator = Validator::make($inputs , array(
			'professional' => 'required|alpha_dash',
			'address' => 'required|alpha_dash',
			'school' => 'required|alpha_dash',
			'qq' => 'numeric',
	        'avatar' => 'required')
		);

		if(!$validator->passes())
		{
			return $this->indexPrompt("", '各项必须填写', $url = "/profile/up");
		}



		$user = new User();
		$teacher = new Teacher();


		if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK )
		{
			$att = new Attachments();
			$re = $att->addTeacherImg(Session::get('uid'), $_FILES['avatar']['tmp_name']);
			if($re)
			{
				$user->setInfo(Session::get('uid'), array('is_certificate' => 1) );
			}
			else
			{
				return $this->indexPrompt("", '必须上传教师资格证', $url = "/profile/up");
			}
		}
		else
		{
			return $this->indexPrompt("", '必须上传教师资格证', $url = "/profile/up");
		}

		$uinfo = $user->getInfoById( Session::get('uid') );
		$tinfo = $teacher->getInfoFromTel($uinfo['tel']);

		$info = array();
		$info['professional'] = $inputs['professional'];
		$info['address'] = $inputs['address'];
		$info['school'] = $inputs['school'];
		$info['qq'] = $inputs['qq'];

		if(empty($tinfo))
		{
			$info['tel'] = $uinfo['tel'];
			$info['name'] = $uinfo['name'];
			Teacher::insert($info);
		}
		else
		{
			Teacher::where('tel', $uinfo['tel'])->update($info);
		}

		return $this->indexPrompt("", '信息已保存，请耐心等待审核通过。', $url = "/profile/up");
	}

}
