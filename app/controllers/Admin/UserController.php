<?php namespace Admin;
use View;
use Session;
use User;

class UserController extends \BaseController {

	public $typeEnum = array('-1' => '管理员', '0' => '学生', '1' => '老师');
	public $statusEnum = array('0' => '未审核', '1' => '审核通过', '-1' => '审核拒绝');

	public function showList()
	{
		$user = new User();
		$data = $user->getList();

		return $this->adminView('userList', array('list' => $data, 'typeEnum' => $this->typeEnum, 'statusEnum' => $this->statusEnum ));
	}

	public function edit()
	{
		
	}

}
