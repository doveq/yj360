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


	public function doProfile()
	{
		$inputs = Input::all();

		$user = new User();

		$update = array();
		if( !empty($inputs['password']) && $inputs['password'] === $inputs['password_confirmation'] )
		{
			$update['password'] = $user->encPasswd( $inputs['password'] );
		}

		if($update)
		{
			$user->setInfo(Session::get('uid'), $update);
		}

		return $this->indexPrompt("", '个人资料修改完成', $url = "/profile");
	}

}
