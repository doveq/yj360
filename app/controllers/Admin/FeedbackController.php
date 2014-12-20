<?php namespace Admin;
use View;
use Session;
use Validator;
use Input;
use Paginator;
use Redirect;
use DB;

use Feedback;

class FeedbackController extends \BaseController {

    public $typeEnum = array('' => '所有类型', '1' => '网站使用', '2' => '其他');
    public $pageSize = 30;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $query = Input::only('page', 'type');

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        $lists = Feedback::where(function($q)
            {
                if (Input::get('type')) {
                    $q->whereType(Input::get('type'));
                }

            })->orderBy('created_at', 'DESC')->paginate($this->pageSize);

        $typeEnum = $this->typeEnum;
        return $this->adminView('feedback.index', compact('query', 'lists', 'typeEnum'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // return $this->adminView('feedback.create');
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
        $feedback = Feedback::find($id);
        $typeEnum = $this->typeEnum;
        return $this->adminView('feedback.show', compact('feedback', 'typeEnum'));

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
        $reply = Input::get('reply');
        Feedback::where('id', $id)->update(array('reply' => $reply));

        return Redirect::to('admin/feedback');
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
        Feedback::destroy($id);
        return Redirect::to('admin/feedback');
    }


}
