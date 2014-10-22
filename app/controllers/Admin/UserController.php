<?php namespace Admin;
use View;
use Session;
use User;
use Validator;
use Input;
use Paginator;
use Redirect;
use Attachments;

class UserController extends \BaseController {

    public $typeEnum = array('' => '所有类型', '-1' => '管理员', '0' => '学生', '1' => '老师');
    public $statusEnum = array('' => '所有状态', '0' => '未审核', '1' => '有效', '-1' => '审核拒绝');
    public $pageSize = 30;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $query = Input::only('name', 'tel', 'type', 'status', 'page');

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        $validator = Validator::make($query,
            array(
                // 'name'   => 'alpha_dash',
                'tel'    => 'numeric',
                'type'   => 'numeric',
                'status' => 'numeric'
            )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "user");
        }

        $lists = User::where(function($query) {
            if (strlen(Input::get('type')) > 0) {
                $query->whereType(Input::get('type'));
            }
            if (strlen(Input::get('status')) > 0) {
                $query->whereStatus(Input::get('status'));
            }
            if (strlen(Input::get('name')) > 0) {
                $query->where('name', 'LIKE', '%'.Input::get('name').'%');
            }
            if (strlen(Input::get('tel')) > 0) {
                $query->where('tel', 'LIKE', Input::get('tel').'%');
            }
        })->orderBy('created_at', 'DESC')->paginate($this->pageSize);

        $statusEnum = $this->statusEnum;
        $typeEnum = $this->typeEnum;
        return $this->adminView('user.index', compact('query', 'lists', 'statusEnum', 'typeEnum'));
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

        if($user['is_certificate'])
        {
            $att = new Attachments();
            $route = $att->getTeacherRoute($id);
            $user['route'] = $route;
        }

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
            array(
                // 'name' => 'alpha_dash',
                'tel' => 'numeric',
                'type' => 'numeric',
                'status' => 'numeric'
                )
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

        if ($user->save()) {
            return Redirect::to('admin/user');
        }
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
