<?php

class ClassesController extends BaseController {

    public $statusEnum = array('' => '所有状态', '0' => '发布', '1' => '撤销发布');
    public $genderEnum = array('f' => '女', 'm' => '男');
    public $pageSize = 10;

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

        $myclasses = array(-1);
        if ($user_type == 1) {
//             $thisclasses = Classes::whereTeacherid($user_id)->whereColumnId($query['column_id'])->get()->toArray();
            // 班级不再区分科目
            $thisclasses = Classes::whereTeacherid($user_id)->get()->toArray();
        }
        if (!empty($thisclasses)) {
            foreach ($thisclasses as $key => $value) {
                $myclasses[] = $value['id'];
            }
        }
        $classmates = Classmate::where(function($q){
            $q->whereTeacherId(Session::get('uid'));
            $q->orWhere('user_id', Session::get('uid'));
        })->whereStatus(1)->select('class_id', 'status')->get()->toArray();

        if (!empty($classmates)) {
            foreach ($classmates as $key => $value) {
                $myclasses[] = $value['class_id'];
            }
        }
//         $classes = Classes::whereIn('id', $myclasses)->whereColumnId($query['column_id'])->orderBy('created_at', 'desc')->get();
        // 班级不再区分科目
        $classes = Classes::whereIn('id', $myclasses)->orderBy('created_at', 'desc')->get();

        $classmate_logs = ClassmateLog::where(function($q){
                $q->whereTeacherId(Session::get('uid'));
                $q->orWhere('user_id', Session::get('uid'));
            })->orderBy('id', 'desc')->paginate($this->pageSize);

        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        $columnHead = Column::whereId($query['column_id'])->first();
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
        $columnHead = Column::whereId($query['column_id'])->first();

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
                'name' => 'required',
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
        $user_id = Session::get('uid');
        $classes = Classes::whereId($id)->first();
        $message = Message::whereReceiverId(Session::get('uid'))
                            ->whereSenderId($classes->teacherid)
                            ->whereStatus(0)->get();
        $classes->message = $message->count();


        $students = $classes->students()->where('classmate.status', 1)->get();
        // dd($students->count());
        foreach ($students as $key => $value) {
            // $message = Message::where(
            //     function($q) use ($value) {
            //         $q->where(function($q) use ($value){
            //             $q->whereSenderId(Session::get('uid'))->whereReceiverId($value->id);
            //         });

            //         $q->orWhere(function($q) use ($value){
            //             $q->whereReceiverId(Session::get('uid'))->whereSenderId($value->id);
            //         });
            // })->whereStatus(0)->get();

            $message = Message::whereReceiverId(Session::get('uid'))
                                ->whereSenderId($value->id)
                                ->whereStatus(0)->get();
            $value->message = $message->count();
        }

        $columns = Column::find($classes->column_id)->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();

        $genderEnum = $this->genderEnum;
        $classmate = $classes->classmates()->where('user_id', Session::get('uid'))->where('status', 1)->get();
        $user_type = Session::get('utype');
        if ($user_type < 0) $user_type = 1;
        $columnHead = Column::whereId($query['column_id'])->first();
        return $this->indexView('classes.show_'.$user_type, compact("classes", 'columns', 'query', 'students', 'classmate', 'genderEnum', 'columnHead'));
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
        $classmates = Classmate::whereClassId($id)->get();
        if ($classmates->count() > 0) {
            return Response::json('删除失败,班级中还有成员');
        }
        Classes::destroy($id);
        // Classmate::whereClassId($id)->delete();
        if (Request::ajax()) {
            return Response::json('ok');
        } else {
            return Redirect::to('/classes/'.$class_id);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function mates()
    {
        $query = Input::all();
        $user_id = Session::get('uid');
        $classes = Classes::whereId($query['class_id'])->first();
        // $message = Message::where(
        //     function($q) use ($classes) {
        //         $q->where(function($q) use ($classes){
        //             $q->whereSenderId(Session::get('uid'))->whereReceiverId($classes->teacherid);
        //         });

        //         $q->orWhere(function($q) use ($classes){
        //             $q->whereReceiverId(Session::get('uid'))->whereSenderId($classes->teacherid);
        //         });
        // })->whereStatus(0)->get();
        // $classes->message = $message->count();


        $students = $classes->students()->where('classmate.status', 1)->select('classmate.id')->get();
        // dd($students);
        // dd($students->count());
        // foreach ($students as $key => $value) {
        //     $message = Message::where(
        //         function($q) use ($value) {
        //             $q->where(function($q) use ($value){
        //                 $q->whereSenderId(Session::get('uid'))->whereReceiverId($value->id);
        //             });

        //             $q->orWhere(function($q) use ($value){
        //                 $q->whereReceiverId(Session::get('uid'))->whereSenderId($value->id);
        //             });
        //     })->whereStatus(0)->get();
        //     $value->message = $message->count();
        // }

        $columns = Column::find($classes->column_id)->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();

        $genderEnum = $this->genderEnum;
        $classmate = $classes->classmates()->where('user_id', Session::get('uid'))->where('status', 1)->get();
        $user_type = Session::get('utype');
        if ($user_type < 0) $user_type = 1;
        $columnHead = Column::find($query['column_id'])->first();
        return $this->indexView('classes.view', compact("classes", 'columns', 'query', 'students', 'classmate', 'genderEnum', 'columnHead'));
    }

    /**
     * 班级管理
     */
    public function manage() {
        $query = Input::only('column_id');
        $uid = Session::get('uid');
        $utype = Session::get('utype');
        if ($utype < 0) {
            $utype = 1;
        }
        if ($utype == 1) {
            // 班级不再区分科目
            $classes = Classes::whereTeacherid($uid)->paginate($this->pageSize);
        } else {
            $classes = array();
        }
        $classes_num = count($classes);
         
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        $columnHead = Column::whereId($query['column_id'])->first();
         
        return $this->indexView('classes.manage',
                compact('columns', 'columnHead', 'query', 'classes', 'classes_num'));
    }
    
    /**
     * 班级管理-保存
     */
    public function manageEdit() {
        $utype = Session::get('utype');
        if ($utype < 0) {
            $utype = 1;
        }
        if($utype != 1) {
            return $this->indexPrompt("操作失败", "错误的访问参数", $url = "/", $auto = true);
        }
         
        $query = Input::only('column_id', 'name', 'id');
        $query['uid'] = Session::get('uid');
         
        $c = new Classes();
        $c->editInfo($query);
         
        return Redirect::to("/classes/manage?column_id=". $query['column_id']);
    }
    
    /**
     * 班级管理-删除
     */
    public function manageDel() {
        $utype = Session::get('utype');
        if ($utype < 0) {
            $utype = 1;
        }
         
        $query = Input::only('id', 'column_id');
        if($utype != 1 || empty($query['id']) || empty($query['column_id'])) {
            return $this->indexPrompt("操作失败", "错误的访问参数", $url = "/", $auto = true);
        }
        $query['uid'] = Session::get('uid');
         
        $classmates = Classmate::whereClassId($query['id'])->get();
        if ($classmates->count() > 0) {
            return $this->indexPrompt("操作失败", "删除失败,班级中还有成员",
                    $url = "/classes/manage?column_id=".$query['column_id'], $auto = true);
        }
         
        $c = new Classes();
        $c->delInfo($query);
         
        return Redirect::to("/classes/manage?column_id=". $query['column_id']);
    }
}
