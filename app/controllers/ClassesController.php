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
        $query = Input::only('page');

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        $user_id = Session::get('uid');
        $classes = Classes::whereTeacherid($user_id)->orderBy('created_at', 'DESC')->paginate($this->pageSize);
        $trainings = Training::whereUserId($user_id)->orderBy('created_at', 'DESC')->paginate($this->pageSize);


        $statusEnum = $this->statusEnum;
        return $this->indexView('classes.index', compact('statusEnum', 'classes', 'trainings', 'query'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->indexView('classes.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $query = Input::only('name');
        $validator = Validator::make($query,
            array(
                'name' => 'alpha_dash',
            )
        );

        if($validator->fails())
        {
            return Redirect::to('training/create')->withErrors($validator)->withInput($query);
        }
        $user_id = Session::get('uid');
        $training = new Classes();
        $training->creater = Session::get('uid');
        $training->teacherid = Session::get('uid');
        $training->name = $query['name'];
        $training->created_at = date("Y-m-d H:i:s");
        if ($training->save()) {
            return Redirect::to('classes');
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
        $classes = Classes::whereId($id)->whereTeacherid(Session::get('uid'))->first();
        // $students      = $classes->students();
        return $this->indexView('classes.show', compact("classes", 'students'));
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