<?php namespace Admin;
use View;
use Session;
use UserLog;
use Validator;
use Input;
use Paginator;
use Redirect;

class LogController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$pageSize = 20;  // 每页显示条数

        $query = Input::only('content', 'user_id', 'type', 'page');
        $query['pageSize'] = $pageSize;
        //$query = array_filter($query); // 删除空值

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;
        // dd($query);
        $validator = Validator::make($query,
            array(
                // 'name'      => 'alpha_dash',
                // 'desc'      => 'alpha_dash',
                // 'online_at' => 'date',
                'type'    => 'numeric',
                'user_id'    => 'numeric'
            )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("查找失败", $validator->messages()->first(), $url = "subject");
        }

        $userlog = new UserLog();
        $info = $userlog->getList($query);

        // 分页
        $paginator = Paginator::make($info['data'], $info['total'], $pageSize);
        unset($query['pageSize']); // 减少分页url无用参数
        $paginator->appends($query);  // 设置分页url参数

        $p = array('list' => $info['data'],
            // 'statusEnum' => $this->statusEnum,
            'query' => $query,
            'paginator' => $paginator );

        return $this->adminView('log.index', $p);
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
