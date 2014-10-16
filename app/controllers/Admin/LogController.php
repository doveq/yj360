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
        $query = Input::only('name', 'url', 'page');

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        $lists = UserLog::where(function($q){
            if (Input::get('name')) {
                $user = User::whereName(Input::get('name'))->first();
                if (!$user) {
                    return Redirect::to('admin/log')->withErrors('未找到用户');
                } else {
                    $q->whereUserId($user->id);
                }
            }
            if (Input::get('url')) {
                $q->where('url', 'like', '%'.Input::get('url').'%');
            }
        })->orderBy("created_at", "DESC")->paginate($this->pageSize);

        foreach ($lists as $key => $list) {
            if ($list->ip) {
                $ip_info = json_decode(file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=" . $list->ip));
                // dd($ip_info);
                if ($ip_info->data->region != $ip_info->data->city) {
                    $list->city = $ip_info->data->region . "," . $ip_info->data->city;
                } else {
                    $list->city = $ip_info->data->region;
                }
            } else {
                $list->city = '';
            }
        }

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
