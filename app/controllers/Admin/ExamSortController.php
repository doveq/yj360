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
use ExamQuestionRelation;
use ExamSort;

class ExamSortController extends \BaseController {
    public $pageSize = 30;
    public $statusEnum = array('0' => '准备', '1' => '上线', '-1' => '下线');
    public $typeEnum = array('0' => '默认', '1' => '题目', '2' => '试卷', '3' => '教材', '4' => '视频', '5' => '游戏');
    // 显示类型,0:无显示,1:分类 2:题目 3:试卷 4:视频 5: 游戏

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        Input::merge(array_map('trim', Input::all() ));
        $query = Input::only('name', 'parent_id', 'page');

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        if (!$query['parent_id']) $query['parent_id'] = 0;

        if ($query['parent_id'] > 0) {
            /*
            // 如果当前分类下添加了题目，则显示题目列表
            $qcount = ExamQuestionRelation::whereColumnId($query['parent_id'])->count();
            if($qcount > 0)
            {
                return Redirect::to('/admin/column/question?id=' . $query['parent_id']);
            }
            */
            
            $parent = ExamSort::find($query['parent_id']);

            $paths = array_reverse($parent->getPath($parent->id));
        }

        $lists = ExamSort::where(function($q){
            if (Input::get('name')) {
                $q->whereName(Input::get('name'));
            }
            if (strlen(Input::get('parent_id')) > 0) {
                $q->whereParentId(Input::get('parent_id'));
            } else {
                $q->whereParentId(0);
            }
        })->orderBy("id", "ASC")->paginate($this->pageSize);

        $statusEnum = $this->statusEnum;
        $typeEnum   = $this->typeEnum;


        return $this->adminView('examSort.index', compact('lists', 'query', 'statusEnum', 'typeEnum', 'parent', 'paths'));
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
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "examSort/create");
        }

        if (!$query['parent_id']) $query['parent_id'] = 0;
        if ($query['parent_id'] == 0) {
            $parent_id = 0;
        } else {
            $parent = ExamSort::find($query['parent_id']);
            $parent_id = $parent->parent_id;
            $paths = array_reverse($parent->getPath($parent->id));
        }
        $column = array('0' => '--所有--');
        $columns = ExamSort::whereParentId($parent_id)->select('id','name')->get();
        foreach ($columns as $key => $value) {
            $column[$value->id] = $value->name;
        }
        // dd($column);
        $typeEnum = $this->typeEnum;
        return $this->adminView('examSort.create', compact('query', 'column', 'typeEnum', 'paths'));
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
                'name'      => 'required',
                'thumbnail' => 'image',
                'parent_id' => 'numeric',
                'type'      => 'numeric',
                )
        );

        if($validator->fails())
        {
            // return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "column/create");
            return Redirect::to('/admin/examSort/create?parent_id='.$query['parent_id'])->withErrors($validator)->withInput($query);
        }
        /*
        if(Input::hasFile('thumbnail')) {
            // $originalName = Input::file('pic')->getClientOriginalName();
            $extension = Input::file('thumbnail')->getClientOriginalExtension();
            $filename = Str::random() . "." . $extension;
            $destinationPath = Config::get('app.thumbnail_dir');
            Input::file('thumbnail')->move($destinationPath, $filename);
            $query['filename'] = $filename;
        }
        */
        $column             = new ExamSort();
        $column->parent_id                                = $query['parent_id'];
        $column->name                                     = $query['name'];
        if ($query['desc']) $column->desc                 = $query['desc'];
        if (isset($query['filename'])) $column->thumbnail = $query['filename'];
        $column->created_at                               = date("Y-m-d H:i:s");
        $column->status                                   = 0;
        //$column->type                                     = $query['type'];
        if (isset($query['ordern']) && $query['ordern'] > 0)
            $column->ordern = $query['ordern'];
        if ($column->save()) {
            if (!isset($query['ordern']) || $query['ordern'] == '') {
                $insertedId = $column->id;
                $column->ordern = $insertedId;
                $column->save();
            }
            return Redirect::to('admin/examSort?parent_id='.$column->parent_id);
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
		$column = ExamSort::find($id);
        $typeEnum = $this->typeEnum;

        $paths = array_reverse($column->getPath($id));
        return $this->adminView('examSort.edit', compact("column", 'typeEnum', 'paths'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$query = Input::only('name', 'desc', 'status', 'thumbnail', 'type', 'ordern');

        $validator = Validator::make($query ,
            array(
                'name'      => 'requiredwith:name',
                'thumbnail' => 'image',
                'status'    => 'numeric',
                'type'      => 'numeric',
                'ordern'      => 'numeric',
                )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "column");
        }
        if (isset($query['name']) && $query['name'] == '') {
            $errors = "名称不能为空";
            return Redirect::to('/admin/examSort/'.$id."/edit")->withErrors($errors)->withInput($query);
        }
        /*
        if(Input::hasFile('thumbnail')) {
            // $originalName = Input::file('pic')->getClientOriginalName();
            $extension = Input::file('thumbnail')->getClientOriginalExtension();
            $filename = Str::random() . "." . $extension;
            $destinationPath = Config::get('app.thumbnail_dir');
            Input::file('thumbnail')->move($destinationPath, $filename);
            $query['filename'] = $filename;
        }
        */
        $column = ExamSort::find($id);

        if (isset($query['name'])) $column->name          = $query['name'];
        if (isset($query['desc'])) $column->desc          = $query['desc'];
        if (isset($query['ordern']) && $query['ordern'] > 0) {
            $column->ordern          = $query['ordern'];
        } else {
            $column->ordern = $column->id;
        }
        if (isset($query['status'])) {
            $column->status      = $query['status'];
            if ($query['status'] == 1) {
                $column->online_at = date("Y-m-d H:i:s");
            } else {
                $column->online_at = NULL;
            }
        }
        if (isset($query['filename'])) $column->thumbnail = $query['filename'];
        //if (isset($query['type'])) $column->type          = $query['type'];

        if ($column->save() ) {
            return Redirect::to('/admin/examSort?parent_id='.$column->parent_id);
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
		$column = ExamSort::find($id);
        $child_count = $column->child->count();
        if ($child_count > 0) {
            return $this->adminPrompt("操作失败", '此分类有子分类,不能删除', $url = "examSort?parent_id=".$column->parent_id);
        }
        $column->delete();
        return Redirect::to('/admin/examSort?parent_id='.$column->parent_id);
	}


    /* 显示分类题目列表 */
    public function questionList()
    {
        $id = Input::get('id');

        $query['id'] = $id;
        $query['parent_id'] = $id;
        if ($id > 0) {
            $parent = ExamSort::find($id);
            $paths = array_reverse($parent->getPath($parent->id));
        }

        $list = ColumnQuestionRelation::with('question')->whereColumnId($id)->paginate(40);

        return $this->adminView('examSort.question', compact('list', 'query', 'paths', 'parent'));
    }

}
