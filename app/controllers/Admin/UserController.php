<?php namespace Admin;
use View;
use Session;
use User;
use Validator;
use Input;
use Paginator;
use Redirect;

class UserController extends \BaseController {

    public $typeEnum = array('' => '所有类型', '-1' => '管理员', '0' => '学生', '1' => '老师');
    public $statusEnum = array('' => '所有状态', '0' => '无效', '1' => '有效', '-1' => '审核拒绝');

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $pageSize = 30;  // 每页显示条数

        $query = Input::only('name', 'tel', 'type', 'status', 'page');
        $query['pageSize'] = $pageSize;
        //$query = array_filter($query); // 删除空值

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        $validator = Validator::make($query,
            array(
                'name'   => 'alpha_dash',
                'tel'    => 'numeric',
                'type'   => 'numeric',
                'status' => 'numeric'
            )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("查找失败", $validator->messages()->first(), $url = "user");
        }

        $user = new User();
        $info = $user->getList($query);

        // 分页
        $paginator = Paginator::make($info['data'], $info['total'], $pageSize);
        unset($query['pageSize']); // 减少分页url无用参数
        $paginator->appends($query);  // 设置分页url参数

        $p = array(
            'list'       => $info['data'],
            'typeEnum'   => $this->typeEnum,
            'statusEnum' => $this->statusEnum,
            'query'      => $query,
            'paginator'  => $paginator
            );

        return $this->adminView('user.index', $p);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
        $user = User::find($id);
        $typeEnum = $this->typeEnum;
        $statusEnum = $this->statusEnum;
        return $this->adminView('user.edit', compact('user', 'typeEnum', 'statusEnum'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
        $data = Input::only('name', 'tel', 'type', 'status');

        $validator = Validator::make($data ,
            array('name' => 'alpha_dash',
                'tel' => 'numeric',
                'type' => 'numeric',
                'status' => 'numeric')
        );

        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "user/".$id."/edit");
        }

        $user = user::find($id);

        if (isset($data['name'])) $user->name     = $data['name'];
        if (isset($data['tel'])) $user->tel       = $data['tel'];
        if (isset($data['type'])) $user->type     = $data['type'];
        if (isset($data['status'])) $user->status = $data['status'];

        $user->save();

        return $this->adminPrompt("操作成功", $validator->messages()->first(), $url = "user");
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
        User::destroy($id);
        return Redirect::to('admin/user');
    }


}
