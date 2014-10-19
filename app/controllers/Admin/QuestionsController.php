<?php namespace Admin;
use View;
use Session;
use Validator;
use Input;
use Paginator;
use Redirect;
use DB;
use Request;

// use Question;
// use Column;
use ColumnQuestionRelation;
use SortQuestionRelation;

class QuestionsController extends \BaseController {

    public $statusEnum = array('' => '所有状态', '0' => '准备', '1' => '上线', '-1' => '下线');
    public $pageSize = 30;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $query = Input::only('id', 'type', 'status', 'page');

        if ($query['type'] == 'sort') {
            return $this->sort($query);
        } else if ($query['type'] == 'column') {
            return $this->column($query);
        } else {
            dd('haha');
        }
    }

    public function sort($query)
    {
        $validator = Validator::make($query,
            array(
                'id'      => 'numeric',
                // 'name' => 'alpha_dash',
                // 'teacher_name' => 'alpha_dash',
                'status' => 'numeric',
            )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("查找失败", $validator->messages()->first(), $url = "questions");
        }
        $lists = SortQuestionRelation::with('question')->where(function($q){
            if (Input::get('id')) {
                $q->whereSortId(Input::get('id'));
            }
        })->orderBy('created_at', 'DESC')->paginate($this->pageSize);
        $statusEnum = $this->statusEnum;
        return $this->adminView('questions.index', compact('query', 'statusEnum', 'lists'));
    }

    public function column($query)
    {
        $validator = Validator::make($query,
            array(
                'id'      => 'numeric',
                // 'name' => 'alpha_dash',
                // 'teacher_name' => 'alpha_dash',
                'status' => 'numeric',
            )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("查找失败", $validator->messages()->first(), $url = "questions");
        }
        $lists = ColumnQuestionRelation::with('question')->where(function($q){
            if (Input::get('id')) {
                $q->whereColumnId(Input::get('id'));
            }
        })->orderBy('created_at', 'DESC')->paginate($this->pageSize);
        $statusEnum = $this->statusEnum;
        return $this->adminView('questions.index', compact('query', 'statusEnum', 'lists'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        echo "error";
        // return $this->adminView('subject_item.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        echo "haha";
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
        $class = Classes::find($id);
        $statusEnum = $this->statusEnum;
        $reses = User::where('type', 1)->select('id','name')->get()->toArray();
        // $teachers = DB::table('users')->select('id','name')->get();
        $teachers = array();
        foreach ($reses as $key => $teacher) {
            $teachers[$teacher['id']] = $teacher['name'];
        }
        // dd($teachers);
        return $this->adminView('classes.edit', compact("class", "statusEnum", "teachers"));
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
        $query = Input::only('id','name','status', 'teacherid', 'memo');
        // dd($data);
        $validator = Validator::make($query,
            array(
                'id'      => 'numeric|required',
                // 'name'  => 'alpha_dash',
                'status'  => 'numeric',
                'teacherid' => 'numeric',
            )
        );
        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "classes");
        }
        $class = Classes::find($id);
        if (isset($query['name'])) $class->name           = $query['name'];
        if (isset($query['status'])) $class->status       = $query['status'];
        if (isset($query['teacherid'])) $class->teacherid = $query['teacherid'];
        if (isset($query['memo'])) $class->memo           = $query['memo'];

        if ($class->save()) {
            return Redirect::to('/admin/classes');
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
        Classes::destroy($id);
        return Redirect::to('admin/classes');
    }


}
