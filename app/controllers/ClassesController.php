<?php

class ClassesController extends BaseController {

    public $statusEnum = array('' => '所有状态', '0' => '发布', '1' => '撤销发布');
    public $genderEnum = array('f' => '女', 'm' => '男');
    public $pageSize = 30;
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
        // dd($user_type);
        if ($user_type < 0) $user_type = 1;


        if ($user_type == 1) {
            $classes = Classes::whereTeacherid($user_id)->whereColumnId($query['column_id'])->orderBy('created_at', 'DESC')->paginate($this->pageSize);
        } elseif ($user_type == 0) {
            $myclasses = array(-1);
            $yqclasses = array(-1);
            $sqclasses = array(-1);
            $classmates = Classmate::whereUserId($user_id)->select('class_id', 'status')->get()->toArray();
            if (!empty($classmates)) {
                foreach ($classmates as $key => $value) {
                    if ($value['status'] == 0) {
                        $myclasses[] = $value['class_id'];
                    } elseif ($value['status'] == 1) {
                        $yqclasses[] = $value['class_id'];
                    } elseif ($value['status'] == 2) {
                        $sqclasses[] = $value['class_id'];
                    }
                }
            }

            $my_classes = Classes::whereIn('id', $myclasses)->get();
            $yq_classes = Classes::whereIn('id', $yqclasses)->get();
            $sq_classes = Classes::whereIn('id', $sqclasses)->get();
        }
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        $genderEnum = $this->genderEnum;
        // dd($user_type);
        return $this->indexView('classes.index_' . $user_type, compact('genderEnum', 'classes', 'query', 'columns','my_classes','yq_classes','sq_classes'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //班级数
        $user_id = Session::get('uid');
        $classes = Classes::whereTeacherid($user_id)->select('id', 'name')->get();
        $classes_num = $classes->count();
        $trainings_num = Training::whereUserId($user_id)->get()->count();
        $query = Input::only('column_id');
        if ($query['column_id']) {
            $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        } else {
            $columns = Column::whereParentId(0)->whereStatus(1)->orderBy('ordern', 'ASC')->select('id', 'name')->get();
            foreach ($columns as $key => $value) {
                $columnall[$value->id] = $value->name;
            }
        }
        return $this->indexView('classes.create', compact('columns', 'query', 'classes_num', 'trainings_num', 'columnall'));
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
        // if (!isset($query['column_id'])) {
            $query['column_id'] = $classes->column_id;
        // }
        $columns = Column::find($classes->column_id)->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();

        $genderEnum = $this->genderEnum;

        $user_type = Session::get('utype');
        if ($user_type < 0) $user_type = 1;
        return $this->indexView('classes.show_'.$user_type, compact("classes", 'columns', 'query', 'genderEnum'));
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
