<?php

class TrainingResultController extends BaseController {

    public $pageSize = 30;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $query = Input::only('training_id', 'column_id');
        $validator = Validator::make($query,
            array(
                'training_id'   => 'numeric|required',
            )
        );

        if($validator->fails())
        {
            return Redirect::to('/training');
        }
        $trainings = Training::find($query['training_id']);
        // dd($trainings->student->count());
        $lists = array();
        $training_res = TrainingResult::whereTrainingId($query['training_id'])->get();
        foreach ($training_res as $key => $res) {
            if (!isset($lists[$res->user_id][$res->res])) {
                $lists[$res->user_id][$res->res] = array($res->question_id);
            } else {
                array_push($lists[$res->user_id][$res->res], $res->question_id);
            }
            if (!isset($lists[$res->user_id]['name'])) {
                $lists[$res->user_id]['name'] = $res->student->name;
            }
        }
        if ($query['column_id']) {
            $columns = Column::find($query['column_id'])->child()->whereStatus(1)->get();
        }
        return $this->indexView('training_result.index', compact('lists', 'trainings', 'query', 'columns'));
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

        $students = User::whereType(0)->whereStatus(1)->whereNotIn('id', $tmp)->where(function($q) {
            if (Input::get('tel')) {
                $q->whereTel(Input::get('tel'));
            }

            if (Input::get('name')) {
                $q->where('name', 'LIKE', '%'.Input::get('name').'%');
            }
        })->orderBy('id', 'DESC')->paginate($this->pageSize);

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


}
