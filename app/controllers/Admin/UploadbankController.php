<?php namespace Admin;
use View;
use Session;
use Validator;
use Input;
use Paginator;
use Redirect;
use DB;
use Config;
use Response;
use Request;

use Uploadbank;
use User;

class UploadbankController extends \BaseController {

    public $statusEnum = array('' => '所有类型', '0' => '未处理', '1' => '已处理');
    public $pageSize = 30;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $query = Input::only('page', 'status');
        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        $lists = Uploadbank::where(function($q)
            {
            if (strlen(Input::get('status')) > 0) {
                $q->whereStatus(Input::get('status'));
            }
        })->orderBy('created_at', 'DESC')->paginate($this->pageSize);

        $statusEnum = $this->statusEnum;
        return $this->adminView('uploadbank.index', compact('query', 'lists', 'statusEnum'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // return $this->adminView('uploadbank.create');
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
        $uploadbank = uploadbank::find($id);
        $file = Config::get('app.uploadbank_dir') . "/" . $uploadbank->filename;
        return Response::download($file, $uploadbank->filename);

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
        $query = Input::only('id','status');
        // dd($data);
        $validator = Validator::make($query,
            array(
                'id'      => 'numeric|required',
                'status'  => 'numeric',
            )
        );
        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "uploadbank");
        }
        $uploadbank = Uploadbank::find($id);
        if ($query['status']) $uploadbank->status = $query['status'];

        if ($uploadbank->save()) {
            return Redirect::to('admin/uploadbank');
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
        Uploadbank::destroy($id);
        return Redirect::to('admin/uploadbank');
    }


}
