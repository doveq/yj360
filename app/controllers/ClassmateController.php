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

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $query = Input::only('class_id', 'page', 'name', 'tel', 'status');
        $query['pageSize'] = $this->pageSize;

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
            return Redirect::to('/classes');
        }
        $classes        = Classes::find($query['class_id']);
        $class_students = $classes->students;
        $tmp = array(0);
        foreach ($class_students as $key => $item) {
            $tmp[] = $item->id;
        }
// dd($tmp);
        $students = User::whereType(0)->whereStatus(1)->whereNotIn('id', $tmp)->where(function($q) {
            if (Input::get('tel')) {
                $q->whereTel(Input::get('tel'));
            }

            if (Input::get('name')) {
                $q->where('name', 'LIKE', '%'.Input::get('name').'%');
            }
        })->orderBy('id', 'DESC')->paginate($this->pageSize);

        // foreach ($students as $key => $student) {
        //     if (in_array($student->id, $tmp)) {
        //         $student->checked = 1;
        //     } else {
        //         $student->checked = 0;
        //     }
        //     $students[$key] = $student;
        // }

        $statusEnum = $this->userstatusEnum;
        $genderEnum = $this->genderEnum;
        return $this->indexView('classmate.create', compact('query', 'classes', 'students', 'teacher','statusEnum', 'genderEnum'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $query = Input::only('class_id', 'student_id');
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

        foreach ($query['student_id'] as $key => $student) {
            Classmate::create(array('user_id' => $student, 'class_id' => $query['class_id'], 'created_at' => date("Y-m-d H:i:s"), 'status' => 1));
        }
        return Redirect::to('/classes/' . $query['class_id']);
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
        $query = Input::only('status');

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

        return Redirect::to('/admin/classmate?class_id=' . $classmate->class_id);
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
        return Redirect::to('admin/classmate?class_id='.$class_id);
    }


}
