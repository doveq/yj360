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

use Sort;

class SortController extends \BaseController {
    public $pageSize = 30;
    public $statusEnum = array('0' => '准备', '1' => '上线', '-1' => '下线');

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

        $lists = Sort::where(function($q){
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
        return $this->adminView('sort.index', compact('lists', 'query', 'statusEnum'));
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
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "sort/create");
        }
        if (!$query['parent_id']) $query['parent_id'] = 0;
        if ($query['parent_id'] == 0) {
            $parent = 0;
        } else {
            $parent = Sort::find($query['parent_id'])->parent_id;
        }

        $sort = array('0' => '--所有--');
        $sorts = Sort::whereParentId($parent)->whereType(0)->select('id','name')->get();
        foreach ($sorts as $key => $value) {
            $sort[$value->id] = $value->name;
        }
        return $this->adminView('sort.create', compact('query', 'sort'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$query = Input::all();
        if (!$query['parent_id']) $query['parent_id'] = 0;

        $validator = Validator::make($query ,
            array(
                'name' => 'required',
                'thumbnail' => 'image',
                'parent_id' => 'numeric',
                )
        );

        if($validator->fails())
        {
            return Redirect::to('/admin/sort/create?parent_id='.$query['parent_id'])->withErrors($validator)->withInput($query);
        }
        if(Input::hasFile('thumbnail')) {
            // $originalName = Input::file('pic')->getClientOriginalName();
            $extension = Input::file('thumbnail')->getClientOriginalExtension();
            $filename = Str::random() . "." . $extension;
            $destinationPath = Config::get('app.thumbnail_dir');
            Input::file('thumbnail')->move($destinationPath, $filename);
            $query['filename'] = $filename;
        }
        $sort             = new Sort();
        $sort->parent_id                                = $query['parent_id'];
        $sort->name                                     = $query['name'];
        if ($query['desc']) $sort->desc                 = $query['desc'];
        if (isset($query['filename'])) $sort->thumbnail = $query['filename'];
        $sort->created_at                               = date("Y-m-d H:i:s");
        $sort->status                                   = 0;
        if ($sort->save()) {
            return Redirect::to('/admin/sort?parent_id='.$sort->parent_id);
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
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "sort");
        }
		$sort = Sort::find($id);
        return $this->adminView('sort.edit', compact("sort"));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$query = Input::only('name', 'desc', 'status', 'thumbnail');

        $validator = Validator::make($query ,
            array(
                'name' => 'requiredwith:name',
                // 'desc' => 'alpha_dash',
                // 'online_at' => 'date',
                'thumbnail' => 'image',
                'status' => 'numeric'
                )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "sort");
        }
        if (isset($query['name']) && $query['name'] == '') {
            $errors = "名称不能为空";
            return Redirect::to('/admin/sort/'.$id."/edit")->withErrors($errors)->withInput($query);
        }
        if(Input::hasFile('thumbnail')) {
            // $originalName = Input::file('pic')->getClientOriginalName();
            $extension = Input::file('thumbnail')->getClientOriginalExtension();
            $filename = Str::random() . "." . $extension;
            $destinationPath = Config::get('app.thumbnail_dir');
            Input::file('thumbnail')->move($destinationPath, $filename);
            $query['filename'] = $filename;
        }
        $sort = Sort::find($id);

        if (isset($query['name'])) $sort->name           = $query['name'];
        if (isset($query['desc'])) $sort->desc           = $query['desc'];
        if (isset($query['status'])) $sort->status       = $query['status'];
        if (isset($query['filename'])) $sort->thumbnail       = $query['filename'];

        if ($sort->save()) {
            return Redirect::to('/admin/sort?parent_id='.$sort->parent_id);
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
		$sort = Sort::find($id);
        $child_count = $sort->child->count();
        if ($child_count > 0) {
            return $this->adminPrompt("操作失败", '此分类有子分类,不能删除', $url = "sort?parent_id=".$sort->parent_id);
        }
        $sort->delete();
        return Redirect::to('/admin/sort?parent_id='.$sort->parent_id);
	}


}
