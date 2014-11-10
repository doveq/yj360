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
        $class_students = $classes->students()->where('classmate.status',1)->get();
        $tmp = array(0);
        foreach ($class_students as $key => $item) {
            $tmp[] = $item->id;
        }

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
            //如果学生申请过, 老师再邀请的时候直接通过
            $sqclass = array();
            $classmate = Classmate::whereUserId($student)->whereClassId($classes->id)->whereStatus(0)->get();
            foreach ($classmate as $key => $value) {
                if ($value->log->type == 2) {
                    $sqclass[] = $value->id;
                }
            }
            if (count($sqclass) > 0) {
                $newclassmate = Classmate::find($sqclass[0]);
                $newclassmate->status = 1;
                $newclassmate->save();
            } else {
                //记录班级关系
                $newclassmate = Classmate::create(
                    array(
                        'user_id' => $student,
                        'teacher_id' => $classes->teacher->id,
                        'class_id' => $query['class_id'],
                        'created_at' => date("Y-m-d H:i:s"),
                        'status' => 0,
                        'type' => 1
                        )
                );
            }
            //记录班级申请日志
            ClassmateLog::create(
                array(
                    'user_id' => $student,
                    'teacher_id' => $classes->teacher->id,
                    'class_id' => $query['class_id'],
                    'created_at' => date("Y-m-d H:i:s"),
                    'classmate_id' => $newclassmate->id,
                    'type' => 1
                    )
            );
            //记录消息
            $user_student = User::find($student);
            $message_content = $classes->teacher->name . "(老师) ". date("Y-m-d H:i:s") . " 邀请 " . $user_student->name . " 加入班级: " . $classes->name;
            Message::create(
                array(
                    'sender_id' => $classes->teacher->id,
                    'receiver_id' => $student,
                    'content' => $message_content,
                    'created_at' => date("Y-m-d H:i:s"),
                    'status' => 1,
                    'type' => 2,
                    'classmate_id' => $newclassmate->id
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
                'column_id' => 'numeric',
                'status' => 'numeric'
                )
        );
        $classmate = Classmate::find($id);

        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "classmate?class_id=".$classmate->class_id);
        }

        if (isset($query['status'])) $classmate->status = $query['status'];

        $classmate->save();
        if (Request::ajax()) {
            return Response::json('ok');
        } else {
            return Redirect::to('/admin/classmate?class_id=' . $classmate->class_id."&column_id=".$query['column_id']);
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
        $classmate = Classmate::find($id);
        $class_id = $classmate->class_id;
        $classmate->delete();
        Message::whereClassmateId($id)->delete();

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
        $query = Input::only('column_id', 'teacher_name', 'class_type');

        $user = User::find(Session::get('uid'));
        if ((isset($query['teacher_name']) && $query['teacher_name']!= '')) {
            if (strlen(Input::get('teacher_name'))>0) {
                $teachers = User::where('type',1)->where('name', 'LIKE', '%'.Input::get('teacher_name').'%')->select('id')->get()->toArray();
                // $q->whereIn('teacherid', array_flatten($teachers));
            }

            if (!empty($teachers)) {
                $classes = Classes::whereIn('teacherid', array_flatten($teachers))->whereColumnId($query['column_id'])->get();
            }
        }
        else
        {
            $classes = Classes::where('column_id', '=', $query['column_id'])->take(12)->get();
        }
        if ($query['column_id']) {
            $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        }

        return $this->indexView('classmate.addclass', compact('query', 'user', 'classes', 'columns'));

    }

    public function doaddClass()
    {
        $query = Input::only('class_id');
        $uid = Session::get('uid');
        $uname = Session::get('uname');
        $thisclass = Classes::find($query['class_id']);
        $classmates = Classmate::whereUserId($uid)->whereNotIn('status', array(2,3))->get();
        $sameclass = array();
        $yqclass = array();
        $max_classes = Config::get('app.max_classes');
        foreach ($classmates as $key => $value) {
            // $everyclass = Classes::find($value->class_id);
            if ($thisclass->id == $value->classes->id) {
                //已经加入
                if ($value->status == 1) {
                    return Response::json('你已经加入此班级');
                }

                //已经被邀请加入, 则状态直接改成加入(1)
                if ($value->log->type == 1 && $value->status == 0) {
                    $yqclass[] = $value->id;
                }
            }
            if ($thisclass->column_id == $value->classes->column_id) {
                $sameclass[] = $value->id;
            }
            if (count($sameclass) >= $max_classes) {
                return Response::json('加入失败,一个科目下只能加入'.$max_classes.'个班级');
            }
        }
        if (!empty($yqclass)) {
            $newclassmate = Classmate::find($yqclass[0]);
            $newclassmate->status = 1;
            $newclassmate->save();
        } else {
            $newclassmate = Classmate::create(
                    array(
                        'user_id' => $uid,
                        'teacher_id' => $thisclass->teacher->id,
                        'class_id' => $query['class_id'],
                        'created_at' => date("Y-m-d H:i:s"),
                        'status' => 0,
                        'type' => 2
                        )
                );
            ClassmateLog::create(
                array(
                    'user_id' => $uid,
                    'teacher_id' => $thisclass->teacher->id,
                    'class_id' => $query['class_id'],
                    'created_at' => date("Y-m-d H:i:s"),
                    'classmate_id' => $newclassmate->id,
                    'type' => 2
                    )
            );
        }
        $message_content = $uname . "(学生) " . date("Y-m-d H:i:s"). " 申请加入班级: " . $thisclass->name;
        Message::create(
            array(
                'sender_id' => $uid,
                'receiver_id' => $thisclass->teacher->id,
                'content' => $message_content,
                'created_at' => date("Y-m-d H:i:s"),
                'status' => 1,
                'type' => 2,
                'classmate_id' => $newclassmate->id
            )
        );
        return Response::json('申请加入成功');

        // if (Request::ajax()) {
        //     return Response::json('ok');
        // } else {
        //     return Redirect::to('/classes/'.$class_id);
        // }
    }

}
