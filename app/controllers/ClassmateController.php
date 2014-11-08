<?php

class ClassmateController extends BaseController {

    public $statusEnum = array('' => '所有状态', '0' => '申请', '1' => '审核通过', '-1' => '无效');
    public $userstatusEnum = array('' => '所有状态', '0' => '无效', '1' => '有效', '-1' => '审核拒绝');
    public $genderEnum = array('f' => '女', 'm' => '男');
    public $pageSize = 30;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
echo "haha";
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $query = Input::only('class_id', 'page', 'name', 'tel', 'status', 'column_id');
// dd($query);
        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        $validator = Validator::make($query,
            array(
                'class_id'   => 'numeric|required',
            )
        );

        if($validator->fails())
        {
            return Redirect::to('/classes?column_id='.$query['column_id']);
        }
        $classes        = Classes::find($query['class_id']);
        $class_students = $classes->students;
        $tmp = array(0);
        foreach ($class_students as $key => $item) {
            $tmp[] = $item->id;
        }

        $sql = User::whereType(0)->whereStatus(1)->whereNotIn('id', $tmp)->where(function($q) {
            if (Input::get('tel')) {
                $q->whereTel(Input::get('tel'));
            }

            if (Input::get('name')) {
                $q->where('name', 'LIKE', '%'.Input::get('name').'%');
            }
        })->orderBy('id', 'DESC')->paginate($this->pageSize);

        // print_r($sql);
        // exit;

        $students = User::whereType(0)->whereStatus(1)->whereNotIn('id', $tmp)->where(function($q) {
            if (Input::get('tel')) {
                $q->whereTel(Input::get('tel'));
            }

            if (Input::get('name')) {
                $q->where('name', 'LIKE', '%'.Input::get('name').'%');
            }
        })->orderBy('id', 'DESC')->paginate($this->pageSize);

        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        $statusEnum = $this->userstatusEnum;
        $genderEnum = $this->genderEnum;


        //print_r(compact('query', 'classes', 'students', 'teacher','statusEnum', 'genderEnum', 'columns'));
        //exit;

        return $this->indexView('classmate.create', compact('query', 'classes', 'students', 'teacher','statusEnum', 'genderEnum', 'columns'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $query = Input::only('class_id', 'student_id', 'column_id');
        $validator = Validator::make($query,
            array(
                'class_id'   => 'numeric|required',
                'student_id' => 'array|required',
            )
        );

        if($validator->fails())
        {
            return Redirect::to('/classes/create?class_id='.$query['class_id'])->withErrors($validator)->withInput($query);
        }

        $classes = Classes::find($query['class_id']);

        foreach ($query['student_id'] as $key => $student) {
            Classmate::create(
                array(
                    'user_id' => $student,
                    'class_id' => $query['class_id'],
                    'created_at' => date("Y-m-d H:i:s"),
                    'status' => 1
                    )
            );
            $message_content = $classes->teacher->name . "邀请你加入:" . $classes->name;
            Message::create(
                array(
                    'sender_id' => $classes->teacher->id,
                    'receiver_id' => $student,
                    'content' => $message_content,
                    'created_at' => date("Y-m-d H:i:s"),
                    'status' => 1
                )
            );
        }
        return Redirect::to('/classes/' . $query['class_id']."?column_id=".$query['column_id']);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        echo 'error';
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
        $query = Input::only('status', 'column_id');

        $validator = Validator::make($query ,
            array(
                // 'desc' => 'alpha_dash',
                // 'online_at' => 'date',
                'status' => 'numeric')
        );
        $classmate = Classmate::find($id);

        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "classmate?class_id=".$classmate->class_id);
        }

        if (isset($query['status'])) $classmate->status = $query['status'];

        $classmate->save();

        return Redirect::to('/admin/classmate?class_id=' . $classmate->class_id."&column_id=".$query['column_id']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $classmate = Classmate::find($id);
        $class_id = $classmate->class_id;
        $classmate->delete();

        if (Request::ajax()) {
            return Response::json('ok');
        } else {
            return Redirect::to('/classes/'.$class_id);
        }
    }

    public function postDelete()
    {
        $query = Input::only('id');
        $validator = Validator::make($query,
            array(
                'id' => 'array|required',
            )
        );
        if($validator->fails())
        {
            return Response::json('error');
        }

        $classmate_ids = (array)$query['id'];
        foreach ($classmate_ids as $key => $classmate_id) {
            $classmate = Classmate::find($classmate_id);
            $class_id = $classmate->class_id;
            $classmate->delete();
        }

        if (Request::ajax()) {
            return Response::json('ok');
        } else {
            return Redirect::to('/classes/'.$class_id);
        }
    }

    public function addClass()
    {
        $query = Input::only('column_id', 'teacher_name');

        // if(empty($query['column_id']) || !is_numeric($query['column_id']))
        //     return $this->indexPrompt("", '请选择正确的科目', $url = "/");

        // dd(Session::get('uid'));
        // $classes = Classes::whereTeacherid($user_id)->whereColumnId($query['column_id'])->orderBy('created_at', 'DESC')->paginate($this->pageSize);
        $user = User::find(Session::get('uid'));
        if (isset($query['teacher_name']) && $query['teacher_name']!= '') {
            if (strlen(Input::get('teacher_name'))>0) {
                $teachers = User::where('type',1)->where('name', 'LIKE', '%'.Input::get('teacher_name').'%')->select('id')->get()->toArray();
                // $q->whereIn('teacherid', array_flatten($teachers));
            }
            if (!empty($teachers)) {
                $classes = Classes::whereIn('teacherid', array_flatten($teachers))->get();
            }
            // $classes = Classes::where(function($q){

            //     if (strlen(Input::get('class_type'))>0) {

            //     }
            // })->get();
        }
        else
        {
            if ($query['column_id']) {
                $classes = Classes::where('column_id', '=', $query['column_id'])->get();
            } else {
                $classes = Classes::get();
            }
        }
        if ($query['column_id']) {
            $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        }


        return $this->indexView('classmate.addclass', compact('query', 'user', 'classes', 'columns'));

    }

}
