<?php namespace Admin;
use View;
use Session;
use Validator;
use Input;
use Paginator;
use Redirect;
use DB;
use Request;

use Training;
use User;

class TrainingController extends \BaseController {

    public $statusEnum = array('' => '所有状态', '0' => '准备', '1' => '上线', '-1' => '下线');
    public $pageSize = 30;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $query = Input::only('name', 'teacher_name', 'status', 'page');

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

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
            return $this->adminPrompt("查找失败", $validator->messages()->first(), $url = "training");
        }
        $lists = Training::where(function($query) {
            if (strlen(Input::get('status')) > 0) {
                $query->whereStatus(Input::get('status'));
            }
            if (Input::get('name')) {
                $query->where('name', 'LIKE', '%'.Input::get('name').'%');
            }
            if (Input::get('teacher_name')) {
                $teachers = User::where('type',1)->where('name', 'LIKE', '%'.Input::get('teacher_name').'%')->select('id')->get()->toArray();
                $query->whereIn('user_id', array_flatten($teachers));

            }
        })->orderBy('created_at', 'DESC')->paginate($this->pageSize);

        $statusEnum = $this->statusEnum;
        return $this->adminView('training.index', compact('query', 'statusEnum', 'lists'));
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
        $training = Training::find($id);
        $statusEnum = $this->statusEnum;
        $reses = User::where('type', 1)->select('id','name')->get()->toArray();
        // $teachers = DB::table('users')->select('id','name')->get();
        $teachers = array();
        foreach ($reses as $key => $teacher) {
            $teachers[$teacher['id']] = $teacher['name'];
        }
        // dd($teachers);
        return $this->adminView('training.edit', compact("training", "statusEnum", "teachers"));
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
        $query = Input::only('id','name','status', 'user_id', 'memo');
        // dd($data);
        $validator = Validator::make($query,
            array(
                'id'      => 'numeric|required',
                // 'name'  => 'alpha_dash',
                'status'  => 'numeric',
                'user_id' => 'numeric',
            )
        );
        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "training");
        }
        if (isset($query['name']) && $query['name'] == '') {
            $errors = "名称不能为空";
            return Redirect::to('/admin/training/'.$id."/edit")->withErrors($errors)->withInput($query);
        }
        $class = Training::find($id);
        if (isset($query['name'])) $class->name           = $query['name'];
        if (isset($query['user_id'])) $class->user_id = $query['user_id'];
        if (isset($query['status'])) $class->status       = $query['status'];

        if ($class->save()) {
            return Redirect::to('/admin/training');
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
        Training::destroy($id);
        return Redirect::to('admin/training');
    }


}
