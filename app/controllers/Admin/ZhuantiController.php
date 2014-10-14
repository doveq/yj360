<?php namespace Admin;
use View;
use Session;
use Validator;
use Input;
use Paginator;
use Redirect;
use DB;
use Request;

use Column;

class ZhuantiController extends \BaseController {
    public $pageSize = 30;
    public $statusEnum = array('0' => '准备', '1' => '上线');

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

// dd(Input::get('parent_id'));
        $lists = Column::where(function($q){
            if (Input::get('name')) {
                $q->whereName(Input::get('name'));
            }
        })->whereType(1)->orderBy("created_at", "DESC")->paginate($this->pageSize);
        $statusEnum = $this->statusEnum;
        return $this->adminView('zhuanti.index', compact('lists', 'query', 'statusEnum'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $query = Input::all();
        // $validator = Validator::make($query ,
        //     array(
        //         'parent_id' => 'numeric'
        //         )
        // );

        // if($validator->fails())
        // {
        //     return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "column/create");
        // }
        // if (!is_null($query['parent_id']) && $query['parent_id'] > 0) {
        //     $parent = Column::find($query['parent_id'])->parent_id;
        // } else {
        //     $parent = 0;
        // }
        // $column = array('' => '--所有--');
        // $columns = Column::whereParentId($parent)->select('id','name')->get();
        // foreach ($columns as $key => $value) {
        //     $column[$value->id] = $value->name;
        // }
        return $this->adminView('zhuanti.create', compact('query'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$query = Input::all();
        $validator = Validator::make($query ,
            array(
                'name' => 'required'
                )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "zhuanti/create");
        }
        $column       = new Column();
        $column->name = $query['name'];
        if ($query['desc']) $column->desc = $query['desc'];
        $column->created_at = date("Y-m-d H:i:s");
        $column->status     = 0;
        $column->type     = 1;
        if ($column->save()) {
            return $this->adminPrompt("操作成功", $validator->messages()->first(), $url = "zhuanti");
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
        $validator = Validator::make(array('id' => $id) ,
            array('id' => 'required|integer',)
        );

        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "zhuanti");
        }
		$column = Column::find($id);
        return $this->adminView('zhuanti.edit', compact("column"));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$query = Input::only('name', 'desc', 'status');

        $validator = Validator::make($query ,
            array(
                // 'name' => 'alpha_dash',
                // 'desc' => 'alpha_dash',
                // 'online_at' => 'date',
                'status' => 'numeric'
                )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "zhuanti");
        }

        $column = Column::find($id);

        if (isset($query['name'])) $column->name           = $query['name'];
        if (isset($query['desc'])) $column->desc           = $query['desc'];
        if (isset($query['status'])) $column->status       = $query['status'];

        $column->save();

        return $this->adminPrompt("操作成功", $validator->messages()->first(), $url = "zhuanti");
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$column = Column::find($id);
        $child_count = $column->questions->count();
        if ($child_count > 0) {
            return $this->adminPrompt("操作失败", '此专题包含题目,不能删除', $url = "zhuanti");
        }
        $column->delete();
        return Redirect::to('admin/zhuanti');
	}


}
