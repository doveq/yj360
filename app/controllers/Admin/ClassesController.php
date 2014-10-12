<?php namespace Admin;
use View;
use Session;
use Validator;
use Input;
use Paginator;
use Redirect;
use DB;

use Classes;
use User;

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
        $query = Input::only('id', 'name', 'teacher_name', 'status', 'page');

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        $validator = Validator::make($query,
            array(
                'id'      => 'numeric',
                'name' => 'alpha_dash',
                'teacher_name' => 'alpha_dash',
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
            if (Input::get('status') == "0") {
                $q->whereStatus(0);
            } else if (Input::get('status') == '1') {
                $q->whereStatus(1);
            } else if (Input::get('status') == '-1') {
                $q->whereStatus(-1);
            }
            if (Input::get('name')) {
                $query->where('name', 'LIKE', '%'.Input::get('name').'%');
            }
            if (Input::get('teacher_name')) {
                $teachers = User::where('type',1)->where('name', 'LIKE', '%'.Input::get('teacher_name').'%')->select('id')->get()->toArray();
                $query->whereIn('teacherid', array_flatten($teachers));

            }
        })->orderBy('id', 'DESC')->paginate($this->pageSize);

        $statusEnum = $this->statusEnum;
        return $this->adminView('classes.index', compact('query', 'statusEnum', 'lists'));
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
                'name'  => 'alpha_dash',
                'status'  => 'numeric',
                'teacherid' => 'numeric',
            )
        );
        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "classes");
        }
        $class = Classes::find($id);
        if ($query['name']) $class->name = $query['name'];
        if ($query['status']) $class->status = $query['status'];
        if ($query['teacherid']) $class->teacherid = $query['teacherid'];
        if ($query['memo']) $class->memo = $query['memo'];

        $class->save();

        return $this->adminPrompt("保存成功", $validator->messages()->first(), $url = "classes");
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
