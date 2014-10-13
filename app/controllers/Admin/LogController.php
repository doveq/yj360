<?php namespace Admin;
use View;
use Session;
use Validator;
use Input;
use Paginator;
use Redirect;
use DB;
use Request;

use UserLog;
use User;

class LogController extends \BaseController {
    public $pageSize = 30;

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $query = Input::only('name', 'page');

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        $validator = Validator::make($query,
            array(
                'name'      => 'alpha_dash',
                // 'online_at' => 'date',
                // 'user_id'    => 'numeric'
            )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("查找失败", $validator->messages()->first(), $url = "log");
        }

        // if (Input::get('name')) {
        //     $user = User::whereName(Input::get('name'))->first();
        //     if (!$user) {
        //         return $this->adminPrompt("未找到用户", '', $url = "log");
        //     } else {
        //         $query['user_id'] = $user->id;
        //     }
        // }
        $lists = UserLog::where(function($q){
            if (Input::get('name')) {
                $user = User::whereName(Input::get('name'))->first();
                if (!$user) {
                    // return $LogController->adminPrompt("未找到用户", '', $url = "log");
                    return Redirect::to('admin/prompt')->with('prompt', array('title' => '未找到用户', 'info' => '未找到用户', 'url' => 'classes', 'auto' => true));
                    // dd("未找到用户");
                } else {
                    $q->whereUserId($user->id);
                }
            }
        })->orderBy("created_at", "DESC")->paginate($this->pageSize);

        return $this->adminView('log.index', compact('lists', 'query'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
	}


}
