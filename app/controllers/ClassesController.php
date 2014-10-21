<?php

class ClassesController extends BaseController {

    public $statusEnum = array('' => '所有状态', '0' => '发布', '1' => '撤销发布');
    public $pageSize = 30;
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
        $classes = Classes::whereTeacherid($user_id)->whereColumnId($query['column_id'])->orderBy('created_at', 'DESC')->paginate($this->pageSize);
        $trainings = Training::whereUserId($user_id)->orderBy('created_at', 'DESC')->paginate($this->pageSize);

        //左边菜单,需要知道是在初级,中级,高级,中小学音乐科目下,如果没有,默认为初级
        if (!isset($query['column_id'])) {
            $query['column_id'] = 3;
        }
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->get();
        $statusEnum = $this->statusEnum;
        return $this->indexView('classes.index_' . $user_type, compact('statusEnum', 'classes', 'trainings', 'query', 'columns'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $query = Input::only('column_id');
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->get();
        return $this->indexView('classes.create', compact('columns', 'query'));
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
                'name' => 'alpha_dash|required',
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
        $classes = Classes::whereId($id)->whereTeacherid(Session::get('uid'))->first();
        if (!isset($query['column_id'])) {
            $query['column_id'] = $classes->column_id;
        }
        $columns = Column::find($classes->column_id)->child()->whereStatus(1)->get();
        return $this->indexView('classes.show', compact("classes", 'columns', 'query'));
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
        Classes::destroy($id);
        Classmate::whereClassId($id)->delete();
        if (Request::ajax()) {
            return Response::json('ok');
        } else {
            return Redirect::to('/classes/'.$class_id);
        }
    }


}
