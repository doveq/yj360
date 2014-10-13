<?php namespace Admin;
use View;
use Session;
use Validator;
use Input;
use Paginator;
use Redirect;
use DB;

use Classmate;
use Classes;
use User;

class ClassmateController extends \BaseController {

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
        $query = Input::only('class_id', 'page');

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        $validator = Validator::make($query,
            array(
                'class_id'      => 'numeric',
            )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("查找失败", $validator->messages()->first(), $url = "classmat?class_id=".$query['class_id']);
        }
        $classes = Classes::find($query['class_id']);
        $lists = $classes->students;
        $teacher = $classes->teacher;
        $statusEnum = $this->statusEnum;
        $genderEnum = $this->genderEnum;

        // $paginator = Paginator::make($lists->toArray(), $lists->count(), $this->pageSize);
        // $paginator->appends($query);  // 设置分页url参数

        return $this->adminView('classmate.index', compact('query', 'statusEnum', 'genderEnum', 'lists', 'classes', 'teacher'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $query = Input::only('class_id','name', 'tel', 'status', 'page');
        $query['pageSize'] = $this->pageSize;

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        $validator = Validator::make($query,
            array(
                // 'name'   => 'alpha_dash',
                'tel'    => 'numeric',
                'class_id'   => 'numeric',
                'status' => 'numeric'
            )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("查找失败", $validator->messages()->first(), $url = "classmate/create?class_id=".$query['class_id']);
        }
        $classes = Classes::find($query['class_id']);
        $teacher = $classes->teacher;
        $class_students = $classes->students;
        $tmp = array();
        foreach ($class_students as $key => $item) {
            $tmp[] = $item->id;
        }
        // $students = User::whereType(0)->whereStatus(1)->orderBy('id', 'DESC')->paginate($this->pageSize);
        $students = User::whereType(0)->whereStatus(1)->where(function($query) {
            if (Input::get('tel')) {
                $query->whereTel(Input::get('tel'));
            }
            if (Input::get('status')) {
                $query->whereStatus(Input::get('status'));
            }
            if (Input::get('name')) {
                $query->where('name', 'LIKE', '%'.Input::get('name').'%');
            }
        })->orderBy('id', 'DESC')->paginate($this->pageSize);

        foreach ($students as $key => $student) {
            if (in_array($student->id, $tmp)) {
                $student->checked = 1;
            } else {
                $student->checked = 0;
            }
            $students[$key] = $student;
        }

        $statusEnum = $this->userstatusEnum;
        $genderEnum = $this->genderEnum;
        return $this->adminView('classmate.create', compact('query', 'classes', 'students', 'teacher','statusEnum', 'genderEnum'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $query = Input::all();

        $cur_ids = array();
        $classes = Classes::find($query['class_id']);
        foreach($classes->students as $list){
          $cur_ids[] = $list->id;
        }
        $a = array_diff($query['student_id'], $cur_ids);
        $b = array_diff($cur_ids, $query['student_id']);
        //detach IDs
        if (!empty($b)) $classes->students()->detach($b);
        //add new IDs
        if (!empty($a)) $classes->students()->attach($a,array('status' => 1));
        // echo "ok";
        return $this->adminPrompt("编辑成功", '', $url = "classmate?class_id=" . $query['class_id']);
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

        return $this->adminPrompt("操作成功", $validator->messages()->first(), $url = "classmate?class_id=".$classmate->class_id);
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
