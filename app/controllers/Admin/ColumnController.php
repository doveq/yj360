<?php namespace Admin;
use View;
use Session;
use Validator;
use Input;
use Paginator;
use Redirect;
use DB;
use Request;
use Str;
use Config;

use Column;

class ColumnController extends \BaseController {
    public $pageSize = 30;
    public $statusEnum = array('0' => '准备', '1' => '上线');

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $query = Input::only('name', 'parent_id', 'page');

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        $lists = Column::where(function($q){
            if (Input::get('name')) {
                $q->whereName(Input::get('name'));
            }
            if (!is_null(Input::get('parent_id'))) {
                $q->whereParentId(Input::get('parent_id'));
            } else {
                $q->whereParentId(0);
            }
        })->whereType(0)->orderBy("id", "ASC")->paginate($this->pageSize);
        $statusEnum = $this->statusEnum;
        return $this->adminView('column.index', compact('lists', 'query', 'statusEnum'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $query = Input::only('parent_id');
        $validator = Validator::make($query ,
            array(
                'parent_id' => 'numeric'
                )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "column/create");
        }
        if (!is_null($query['parent_id']) && $query['parent_id'] > 0) {
            $parent = Column::find($query['parent_id'])->parent_id;
        } else {
            $parent = 0;
        }
        $column = array('' => '--所有--');
        $columns = Column::whereParentId($parent)->whereType(0)->select('id','name')->get();
        foreach ($columns as $key => $value) {
            $column[$value->id] = $value->name;
        }
        return $this->adminView('column.create', compact('query', 'column'));
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
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "column/create");
        }
        if(Input::hasFile('thumbnail')) {
            // $originalName = Input::file('pic')->getClientOriginalName();
            $extension = Input::file('thumbnail')->getClientOriginalExtension();
            $filename = Str::random() . "." . $extension;
            $destinationPath = Config::get('app.column_thumbnail_dir');
            Input::file('thumbnail')->move($destinationPath, $filename);
            $query['filename'] = $filename;
        }
        $column             = new Column();
        if ($query['parent_id'] > 0) {
            $column->parent_id = $query['parent_id'];
        } else {
            $column->parent_id = 0;
        }
        $column->name                              = $query['name'];
        if ($query['desc']) $column->desc          = $query['desc'];
        if ($query['filename']) $column->thumbnail = $query['filename'];
        $column->created_at                        = date("Y-m-d H:i:s");
        $column->status                            = 0;
        $column->type                              = 0;
        if ($column->save()) {
            return $this->adminPrompt("操作成功", $validator->messages()->first(), $url = "column?parent_id=".$query['parent_id']);
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
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "column");
        }
		$column = Column::find($id);
        return $this->adminView('column.edit', compact("column"));
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
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "column");
        }
        if(Input::hasFile('thumbnail')) {
            // $originalName = Input::file('pic')->getClientOriginalName();
            $extension = Input::file('thumbnail')->getClientOriginalExtension();
            $filename = Str::random() . "." . $extension;
            $destinationPath = Config::get('app.column_thumbnail_dir');
            Input::file('thumbnail')->move($destinationPath, $filename);
            $query['filename'] = $filename;
            // dd($filename);
        }
        $column = Column::find($id);

        if (isset($query['name'])) $column->name           = $query['name'];
        if (isset($query['desc'])) $column->desc           = $query['desc'];
        if (isset($query['status'])) $column->status       = $query['status'];
        if (isset($query['filename'])) $column->thumbnail       = $query['filename'];

        $column->save();

        return $this->adminPrompt("操作成功", $validator->messages()->first(), $url = "column?parent_id=" . $column->parent_id);
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
        $child_count = $column->child->count();
        if ($child_count > 0) {
            return $this->adminPrompt("操作失败", '此科目有子科目,不能删除', $url = "column?parent_id=".$column->parent_id);
        }
        $column->delete();
        return Redirect::to('admin/column?parent_id='.$column->parent_id);
	}


}
