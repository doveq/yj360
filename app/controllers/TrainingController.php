<?php

class TrainingController extends BaseController {

    public $statusEnum = array('' => '所有状态', '0' => '发布', '1' => '撤销发布');
    public $pageSize = 30;

    public function __construct()
    {
        $query = Input::only('column_id');

        if ((!isset($query['column_id']) || !is_numeric($query['column_id'])) && Request::path() != 'column/static') {
            echo ("<script>window.location.href='/column/static';</script>");
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $query = Input::only('page', 'column_id' );

        $user_id = Session::get('uid');
        $user_type = Session::get('utype');
        if ($user_type < 0) $user_type = 1;
        //分为老师和学生
        if ($user_type == 1) {
            //老师
            $classeses = Classes::whereTeacherid($user_id)->select('id')->get()->toArray();
            $lists = Training::whereIn('class_id', $classeses)->orderBy('created_at', 'DESC')->paginate($this->pageSize);
        } else {
            //学生
            $classeses = Classmate::whereUserId($user_id)->whereStatus(1)->select('class_id')->get()->toArray();
            $lists = Training::whereIn('class_id', $classeses)->whereStatus(1)->orderBy('created_at', 'DESC')->paginate($this->pageSize);
        }
        // dd($classeses);
        if ($query['column_id']) {
            $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        }
        // 获取父类名页面显示
        $cn = new Column();
        $arr = $cn->getPath($query['column_id']);
        $columnHead = $arr[0];

        $statusEnum = $this->statusEnum;
        return $this->indexView('training.index_'.$user_type, compact('statusEnum', 'lists', 'query', 'columns', 'columnHead'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $query = Input::only('column_id');
        $user_id = Session::get('uid');
        $classes = Classes::whereTeacherid($user_id)->whereColumnId($query['column_id'])->select('id', 'name')->get();
        $classeses = array();
        foreach ($classes as $key => $c) {
            $classeses[$c->id] = $c->name;
        }

        $classes_num = $classes->count();
        $trainings_num = Training::whereUserId($user_id)->get()->count();
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        // 获取父类名页面显示
        $columnHead = Column::whereId($query['column_id'])->first();
        return $this->indexView('training.create', compact('columns', 'query', 'classeses', 'classes_num', 'trainings_num', 'columnHead'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $query = Input::only('name', 'column_id', 'class_id');
        $validator = Validator::make($query,
            array(
                'name' => 'alpha_dash',
            )
        );

        if($validator->fails())
        {
            return Redirect::to('training/create?column_id='.$query['column_id'])->withErrors($validator)->withInput($query);
        }
        $user_id = Session::get('uid');
        $training = new Training();
        $training->user_id = Session::get('uid');
        $training->name = $query['name'];
        $training->class_id = $query['class_id'];
        $training->created_at = date("Y-m-d H:i:s");
        if ($training->save()) {
            return Redirect::to('training?column_id='. $query['column_id']);
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
        $query = Input::only('id','status', 'column_id');
        // dd($data);
        $validator = Validator::make($query,
            array(
                'id'      => 'numeric',
                'status'  => 'numeric',
            )
        );
        // dd($query['status']);
        if($validator->fails())
        {
            if (Request::ajax()) {
                return Response::json('error');
            }
        }
        $training = Training::find($id);
        if (isset($query['status'])) {
            $training->status       = $query['status'];
            if ($query['status'] == 1) {
                $training->online_at = date("Y-m-d H:i:s");
            } else {
                $training->online_at = NULL;
            }
        }

        if ($training->save()) {
            if (Request::ajax()) {
                return Response::json('ok');
            } else {
                return Redirect::to('/training');
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
        $training = Training::find($id);
        $training->questions()->detach();
        $training->delete();
        return Redirect::to('training');
    }


}
