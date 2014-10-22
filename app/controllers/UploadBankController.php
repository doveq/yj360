<?php

class UploadBankController extends BaseController {

    public $statusEnum = array('' => '所有状态', '0' => '发布', '1' => '撤销发布');
    public $pageSize = 30;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $query = Input::only('page', 'column_id' );

        $user_id = Session::get('uid');
        $lists = Uploadbank::whereUserId($user_id)->orderBy('created_at', 'DESC')->paginate($this->pageSize);

        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->get();
        $statusEnum = $this->statusEnum;
        return $this->indexView('uploadbank.index', compact('statusEnum', 'lists', 'query', 'columns'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // $user_id = Session::get('uid');
        // $classes_num = Classes::whereTeacherid($user_id)->get()->count();
        // $trainings_num = Training::whereUserId($user_id)->get()->count();
        $query = Input::only('column_id');
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->get();
        return $this->indexView('uploadbank.create', compact('columns', 'query'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $query = Input::only('name', 'column_id');
        $validator = Validator::make($query,
            array(
                'name' => 'alpha_dash',
            )
        );

        if($validator->fails())
        {
            return Redirect::to('uploadbank/create?column_id='.$query['column_id'])->withErrors($validator)->withInput($query);
        }
        $user_id = Session::get('uid');
        $uploadbank = new Uploadbank();
        $uploadbank->user_id = Session::get('uid');
        $uploadbank->name = $query['name'];
        $uploadbank->created_at = date("Y-m-d H:i:s");
        if ($uploadbank->save()) {
            return Redirect::to('uploadbank?column_id='. $query['column_id']);
        }
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
        // echo "hahah";
        $training = Training::find($id);
        $statusEnum = $this->statusEnum;
        $reses = User::where('type', 1)->select('id','name')->get()->toArray();
        // $teachers = DB::table('users')->select('id','name')->get();
        $teachers = array();
        foreach ($reses as $key => $teacher) {
            $teachers[$teacher['id']] = $teacher['name'];
        }
        // dd($teachers);
        return $this->adminView('training.edit', compact("training", "statusEnum", "teachers"));
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
        $query = Input::only('id','name','status', 'user_id', 'memo');
        // dd($data);
        $validator = Validator::make($query,
            array(
                'id'      => 'numeric',
                // 'name'  => 'alpha_dash',
                'status'  => 'numeric',
                'user_id' => 'numeric',
            )
        );
        // dd($query['status']);
        if($validator->fails())
        {
            if (Request::ajax()) {
                return Response::json('error');
            } else {
                return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "training");
            }
        }
        if (isset($query['name']) && $query['name'] == '') {
            $errors = "名称不能为空";
            if (Request::ajax()) {
                return Response::json('error');
            } else {
                return Redirect::to('/admin/training/'.$id."/edit")->withErrors($errors)->withInput($query);
            }
        }
        $class = Training::find($id);
        if (isset($query['name'])) $class->name           = $query['name'];
        if (isset($query['user_id'])) $class->user_id = $query['user_id'];
        if (isset($query['status'])) $class->status       = $query['status'];

        if ($class->save()) {
            if (Request::ajax()) {
                return Response::json('ok');
            } else {
                return Redirect::to('/admin/training');
            }
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
        Uploadbank::destroy($id);
        return Redirect::to('admin/training');
    }


}
