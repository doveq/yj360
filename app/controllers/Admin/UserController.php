<?php namespace Admin;
use View;
use Session;
use User;
use Validator;
use Input;

class UserController extends \BaseController {

	public $typeEnum = array('-1' => '管理员', '0' => '学生', '1' => '老师');
	public $statusEnum = array('0' => '未审核', '1' => '审核通过', '-1' => '审核拒绝');

	public function showList()
	{
		$query = Input::only('name', 'tel', 'type', 'status');
		//$query = array_filter($query); // 删除空值

		$validator = Validator::make($query, 
			array('name' => 'alpha_dash',
				'tel' => 'numeric',
				'type' => 'numeric',
				'status' => 'numeric')
		);

		if($validator->fails())
    	{
        	dd( $validator->messages()->all() );
    	}

		$user = new User();
		$data = $user->getList($query);
		return $this->adminView('userList', array('list' => $data, 'typeEnum' => $this->typeEnum, 'statusEnum' => $this->statusEnum, 'query' => $query ));
	}

	public function showEdit($id)
	{
		$validator = Validator::make(array('id' => $id) , 
			array('id' => 'required|integer',)
		);

		if($validator->fails())
    	{
        	dd( $validator->messages()->all() );
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
        	dd( $validator->messages()->all() );
    	}

    	$user = new User();
    	$user->setInfo($data['id'], array('type' => $data['type'], 'status' => $data['status']) );

    	echo "跟新成功！";
	}

	public function doDel()
	{

	}

}
