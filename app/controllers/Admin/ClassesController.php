<?php namespace Admin;
use View;
use Session;
use Validator;
use Input;
use Paginator;
use Redirect;
use DB;
use Request;

use Classes;
use User;
use Column;

class ClassesController extends \BaseController {

    public $statusEnum = array('' => '所有状态', '0' => '准备', '1' => '上线', '-1' => '下线');
    public $pageSize = 30;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        Input::merge(array_map('trim', Input::only('id', 'name', 'teacher_name', 'status', 'column_id', 'page')) );
        $query = Input::only('id', 'name', 'teacher_name', 'status', 'column_id', 'page');

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
            return $this->adminPrompt("查找失败", $validator->messages()->first(), $url = "classes");
        }
        $lists = Classes::where(function($query) {
            if (Input::get('id')) {
                $query->whereId(Input::get('id'));
            }
            if (strlen(Input::get('status')) > 0) {
                $query->whereStatus(Input::get('status'));
            }
            if (strlen(Input::get('column_id')) > 0) {
                $query->whereColumnId(Input::get('column_id'));
            }
            if (Input::get('name')) {
                $query->where('name', 'LIKE', '%'.Input::get('name').'%');
            }
            if (Input::get('teacher_name')) {
                $teachers = User::where('type',1)->where('name', 'LIKE', '%'.Input::get('teacher_name').'%')->select('id')->get()->toArray();
                
                if(!empty($teachers))
                    $query->whereIn('teacherid', array_flatten($teachers));
                else
                    $query->where('teacherid', '');
            }
        })->orderBy('id', 'DESC')->paginate($this->pageSize);

        $cs = Column::whereParentId(0)->select('id', 'name')->get()->toArray();
        // dd($columns);
        $columns = array('' => '所有科目');
        foreach ($cs as $key => $c) {
            $columns[$c['id']] = $c['name'];
        }
        $statusEnum = $this->statusEnum;
        return $this->adminView('classes.index', compact('query', 'statusEnum', 'lists', 'columns'));
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
        $cs = Column::whereParentId(0)->select('id', 'name')->get()->toArray();
        // dd($columns);
        foreach ($cs as $key => $c) {
            $columns[$c['id']] = $c['name'];
        }
        return $this->adminView('classes.edit', compact("class", "statusEnum", "teachers", "columns"));
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
        $query = Input::only('id','name','status', 'teacherid', 'column_id', 'memo');
        // dd($data);
        $validator = Validator::make($query,
            array(
                'id'      => 'numeric|required',
                // 'name'  => 'alpha_dash',
                'status'  => 'numeric',
                'teacherid' => 'numeric',
                'column_id' => 'numeric',
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
        if (isset($query['column_id'])) $class->column_id = $query['column_id'];
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
