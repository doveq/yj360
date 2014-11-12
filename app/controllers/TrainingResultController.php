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
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        // 获取父类名页面显示
        $cn = new Column();
        $arr = $cn->getPath($query['column_id']);
        $columnHead = $arr[0];
        return $this->indexView('training_result.index', compact('lists', 'trainings', 'query', 'columns', 'columnHead'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

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

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {

    }

    public function postDelete()
    {

    }


}
