<?php

class ClassesController extends BaseController {

    public $statusEnum = array('' => '所有状态', '0' => '发布', '1' => '撤销发布');
    public $genderEnum = array('f' => '女', 'm' => '男');
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
        $query = Input::only('column_id');
        $user_id = Session::get('uid');
        $user_type = Session::get('utype');
        if ($user_type < 0) $user_type = 1;
        //正式班级
        if ($user_type == 1) {
            $classes = Classes::whereTeacherid($user_id)->whereColumnId($query['column_id'])->orderBy('created_at', 'DESC')->paginate($this->pageSize);
            $myclasses = array(-1);
            foreach ($classes as $key => $value) {
                $myclasses[] = $value->id;
            }
            $classmate_logs = ClassmateLog::whereTeacherId($user_id)->orderBy('id', 'desc')->get();
        } elseif ($user_type == 0) {
            $myclasses = array(-1);
            $classmates = Classmate::whereUserId($user_id)->whereStatus(1)->select('class_id', 'status')->get()->toArray();
            if (!empty($classmates)) {
                foreach ($classmates as $key => $value) {
                    $myclasses[] = $value['class_id'];
                }
            }
            $classes = Classes::whereIn('id', $myclasses)->get();

            $classmate_logs = ClassmateLog::whereUserId($user_id)->orderBy('id', 'desc')->get();
        }

        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        $columnHead = Column::find($query['column_id'])->first();
        $genderEnum = $this->genderEnum;
        return $this->indexView('classes.index_' . $user_type, compact('genderEnum', 'classes', 'query', 'columns', 'classmate_logs', 'columnHead'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $query = Input::only('column_id');
        //班级数
        $user_id = Session::get('uid');
        $classes = Classes::whereTeacherid($user_id)->select('id', 'name')->get();
        $classes_num = $classes->count();
        $trainings_num = Training::whereUserId($user_id)->get()->count();
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        $columnHead = Column::find($query['column_id'])->first();

        return $this->indexView('classes.create', compact('columns', 'query', 'classes_num', 'trainings_num', 'columnHead'));
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
                'name' => 'alpha_dash|required',
                'column_id' => 'numeric|required',
            )
        );

        if($validator->fails())
        {
            return Redirect::to('classes/create?column_id='.$query['column_id'])->withErrors($validator)->withInput($query);
        }
        $user_id = Session::get('uid');
        $training = new Classes();
        $training->creater = Session::get('uid');
        $training->teacherid = Session::get('uid');
        $training->name = $query['name'];
        $training->column_id = $query['column_id'];
        $training->created_at = date("Y-m-d H:i:s");
        $training->status = 1; // 默认上线
        if ($training->save()) {
            return Redirect::to('classes?column_id='. $query['column_id']);
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
        $query = Input::all();
        $classes = Classes::whereId($id)->first();
        $students = $classes->students()->where('classmate.status', 1)->get();
        // dd($students->count());

        $columns = Column::find($classes->column_id)->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();

        $genderEnum = $this->genderEnum;
        $classmate = $classes->classmates()->where('user_id', Session::get('uid'))->where('status', 1)->get();
        $user_type = Session::get('utype');
        if ($user_type < 0) $user_type = 1;
        return $this->indexView('classes.show_'.$user_type, compact("classes", 'columns', 'query', 'students', 'classmate', 'genderEnum'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Classes::destroy($id);
        Classmate::whereClassId($id)->delete();
        if (Request::ajax()) {
            return Response::json('ok');
        } else {
            return Redirect::to('/classes/'.$class_id);
        }
    }


}
