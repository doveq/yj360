<?php

class UploadBankController extends BaseController {

    public $statusEnum = array('' => '所有状态', '0' => '发布', '1' => '撤销发布');
    public $pageSize = 30;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $query = Input::only('page', 'column_id' );

        $user_id = Session::get('uid');
        $lists = Uploadbank::whereUserId($user_id)->orderBy('created_at', 'DESC')->paginate($this->pageSize);

        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        $statusEnum = $this->statusEnum;
        return $this->indexView('uploadbank.index', compact('statusEnum', 'lists', 'query', 'columns'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user_id = Session::get('uid');
        $query = Input::only('column_id');
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->get();

        $lists = Uploadbank::whereUserId($user_id)->orderBy('created_at', 'DESC')->paginate($this->pageSize);
        return $this->indexView('uploadbank.create', compact('columns', 'query', 'lists'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $query = Input::all();

        $validator = Validator::make($query,
            array(
                'name' => 'required',
                'qq' => 'numeric',
                'filename' => 'required',
            )
        );

        if($validator->fails())
        {
            unset($query['filename']);
            return Redirect::to('uploadbank/create?column_id='.$query['column_id'])->withErrors($validator)->withInput($query);
        }
        // dd (Config::get('app.uploadbank_dir'));
        if(Input::hasFile('filename')) {
            $originalName = explode(".", Input::file('filename')->getClientOriginalName());
            $extension = Input::file('filename')->getClientOriginalExtension();
            $filename = Session::get('uid') . "-" .Session::get('uname') . "-"  . $originalName[0] . "-" . Str::random() . "." . $extension;
            $destinationPath = Config::get('app.uploadbank_dir');
            Input::file('filename')->move($destinationPath, $filename);
            $query['filename'] = $filename;
        }
        $uploadbank = new Uploadbank();
        $uploadbank->user_id = Session::get('uid');
        $uploadbank->name = $query['name'];
        $uploadbank->created_at = date("Y-m-d H:i:s");
        if (isset($query['desc'])   && $query['desc'] != '') $uploadbank->desc         = $query['desc'];
        if (isset($query['tel'])  && $query['tel'] != '') $uploadbank->tel           = $query['tel'];
        if (isset($query['qq']) && $query['qq'] > 0) $uploadbank->qq             = $query['qq'];
        if (isset($query['filename'])) $uploadbank->filename = $query['filename'];

        if ($uploadbank->save()) {
            return Redirect::to('uploadbank?column_id='. $query['column_id']);
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
        //
        Uploadbank::destroy($id);
        if (Request::ajax()) {
            return Response::json('ok');
        } else {
            return Redirect::to('uploadbank');
        }
    }


}
