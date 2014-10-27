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
}
