<?php namespace Admin;
use View;
use Session;
use User;
use Validator;
use Input;
use Paginator;

class UserController extends \BaseController {

	public $typeEnum = array('-1' => '管理员', '0' => '学生', '1' => '老师');
	public $statusEnum = array('0' => '未审核', '1' => '审核通过', '-1' => '审核拒绝');

	public function showList()
	{
		$pageSize = 2;  // 每页显示条数

		$query = Input::only('name', 'tel', 'type', 'status', 'page');
		$query['pageSize'] = $pageSize;
		//$query = array_filter($query); // 删除空值

		// 当前页数
		if( !is_numeric($query['page']) || $query['page'] < 1 )
			$query['page'] = 1;

		$validator = Validator::make($query,
			array('name' => 'alpha_dash',
				'tel' => 'numeric',
				'type' => 'numeric',
				'status' => 'numeric')
		);

		if($validator->fails())
    	{
        	#dd( $validator->messages()->all() );
        	return $this->adminPrompt("用户查找失败", $validator->messages()->first(), $url = "userList");
    	}

		$user = new User();
		$info = $user->getList($query);


		// 分页
		$paginator = Paginator::make($info['data'], $info['total'], $pageSize);
		unset($query['pageSize']); // 减少分页url无用参数
		$paginator->appends($query);  // 设置分页url参数

		$p = array('list' => $info['data'],
			'typeEnum' => $this->typeEnum,
			'statusEnum' => $this->statusEnum,
			'query' => $query,
			'paginator' => $paginator );

		return $this->adminView('userList', $p);
	}

	public function showEdit($id)
	{
		$validator = Validator::make(array('id' => $id) ,
			array('id' => 'required|integer',)
		);

		if($validator->fails())
    	{
        	#dd( $validator->messages()->all() );
        	return $this->adminPrompt("用户查找失败", $validator->messages()->first(), $url = "userList");
    	}

    	$user = new User();
    	$data = $user->getInfoById($id);
		return $this->adminView('userEdit', array('user' => $data, 'typeEnum' => $this->typeEnum, 'statusEnum' => $this->statusEnum));
	}

	public function doEdit()
	{
		$data = Input::all();
		$validator = Validator::make($data ,
			array('id' => 'required|integer',
				'type' => 'required|numeric',
				'status' => 'required|numeric')
		);

		if($validator->fails())
    	{
        	#dd( $validator->messages()->all() );
        	return $this->adminPrompt("操做失败", $validator->messages()->first(), $url = "userList");
    	}

    	$user = new User();
    	$user->setInfo($data['id'], array('type' => $data['type'], 'status' => $data['status']) );

    	echo "跟新成功！";
	}

	public function doDel()
	{
		$data = Input::all();
		$validator = Validator::make($data , array('id' => 'required|integer') );

		if($validator->fails())
    	{
        	#dd( $validator->messages()->all() );
        	return $this->adminPrompt("用户删除失败", $validator->messages()->first(), $url = "userList");
    	}

    	$user = new User();
    	$user->del($data['id']);

    	return $this->adminPrompt("操做成功", "用户删除成功!", $url = "userList");
	}

}
