<?php namespace Admin;
use View;
use Session;
use Input;
use Column;
use ExamPaper;
use Validator;
use Redirect;
use ExamSort;
use ExamQuestionRelation;
use ColumnQuestionRelation;
use ColumnExamRelation;
use DB;

class ExamPaperController extends \BaseController {

	public $statusEnum = array('0' => '未审核', '1' => '上线', '-1' => '下线');

	public function index()
	{
        Input::merge(array_map('trim', Input::all() ));
		$query = Input::only('sort1','sort2','sort3','sort4','sort5','name','status');

        /*
		$parent = Column::find($columnId);
        $paths = array_reverse($parent->getPath($parent->id));
        */

        $query['sort'] = 0;
        if( !empty($query['sort5']) )
            $query['sort'] = $query['sort5'];
        elseif( !empty($query['sort4']) )
            $query['sort'] = $query['sort4'];
        elseif( !empty($query['sort3']) )
            $query['sort'] = $query['sort3'];
        elseif( !empty($query['sort2']) )
            $query['sort'] = $query['sort2'];
        elseif( !empty($query['sort1']) )
            $query['sort'] = $query['sort1'];

        // 显示列表
        $ep = new ExamPaper();
        $lists = $ep->getElist($query)->paginate(30);
        //var_dump( DB::getQueryLog() );

        $statusEnum = $this->statusEnum;
        $statusEnum = array('' => '所有状态') + $statusEnum;

		return $this->adminView('examPaper.index', compact('query', 'lists', 'statusEnum') );
	}

	public function showAdd()
	{
		$columnId = Input::get('column_id');

		// $parent = Column::find($columnId);
  //       $paths = array_reverse($parent->getPath($parent->id));

        $info = array();
        $info['sort1'] = 0;
        $info['sort2'] = 0;
        $info['sort3'] = 0;
        $info['sort4'] = 0;
        $info['sort5'] = 0;

		return $this->adminView('examPaper.add', compact('parent', 'paths', 'columnId', 'info') );
	}

	public function showEdit()
	{
		$id = Input::get('id');
		$info = ExamPaper::find($id);

		// $parent = Column::find($info->column_id);
  //       $paths = array_reverse($parent->getPath($parent->id));

  //       $columnId = $info->column_id;


        $info['sort1'] = 0;
        $info['sort2'] = 0;
        $info['sort3'] = 0;
        $info['sort4'] = 0;
        $info['sort5'] = 0;

        $sort = new ExamSort();
        $sortInfo = $sort->getPath($info['sort']);
        $sortNum = count($sortInfo);
        for ($i = $sortNum; $i > 0; $i--) 
        {
            $v = $sortNum - $i +1;
            $info['sort' . $v] = $sortInfo[$i -1]['id'];

            //Session::put('sort'.$v, $info['sort' . $v]);
        }

		return $this->adminView('examPaper.add', compact('info') );
	}

	// 显示大题列表
	public function showClist()
	{
		$id = Input::get('id');
		if(!is_numeric($id))
			return $this->adminPrompt("操作失败", '错误的试卷ID');

		$ep = new ExamPaper();
		$info = $ep->find($id);

		$lists = $ep->getClist($id);
        foreach ($lists as &$v) {
            $v->count = $ep->getQuestionsCount($v->id);
        }

		// $parent = Column::find($info->column_id);
  //       $paths = array_reverse($parent->getPath($parent->id));

		return $this->adminView('examPaper.clist', compact('info', 'lists', 'parent', 'paths', 'lists') );
	}

	public function doAdd()
	{
		$query = Input::all();
        $validator = Validator::make($query,
            array(
                'title' => 'required'
            )
        );

        // 处理分类
        $query['sort'] = 0;
        if( !empty($query['sort5']) )
            $query['sort'] = $query['sort5'];
        elseif( !empty($query['sort4']) )
            $query['sort'] = $query['sort4'];
        elseif( !empty($query['sort3']) )
            $query['sort'] = $query['sort3'];
        elseif( !empty($query['sort2']) )
            $query['sort'] = $query['sort2'];
        elseif( !empty($query['sort1']) )
            $query['sort'] = $query['sort1'];

        // 不是添加题干，并且每有选择分类
        if($validator->fails() || ( empty($query['parent_id']) && $query['sort'] == 0) )
        {
            //return Redirect::to('/admin/examPaper/add?column_id='.$query['column_id'])->withErrors($validator)->withInput($query);
            if(isset($query['from']))
                return $this->adminPrompt("操作失败", '信息必须填写完整，请反回重试', $query['from']);
            else
                return $this->adminPrompt("操作失败", '信息必须填写完整，请反回重试', '/admin/examPaper/add');
        }

        $ep = new ExamPaper();
        $id = $ep->add($query);

        //return Redirect::to('/admin/column?parent_id='.$query['column_id']);

        if(isset($query['from']))
        {
            //return $this->adminPrompt("操作成功", '提交编辑成功', $query['from']);
            return Redirect::to($query['from']);
        }
        else
        {
            // 如果是添加的试卷，则跳到添加题干页
            if( empty($query['parent_id']) )
            {
                //return $this->adminPrompt("操作成功", '提交编辑成功', '/admin/examPaper/clist?id=' . $id);
                return Redirect::to('/admin/examPaper/clist?id=' . $id);
            }
            else
                return $this->adminPrompt("操作成功", '提交编辑成功', '/admin/examPaper');
        }
	}

	public function doEdit()
	{
		$query = Input::all();
        $validator = Validator::make($query,
            array(
                'title' => 'required',
                'id' => 'numeric|required',
            )
        );

        if($validator->fails())
        {
            if(isset($query['from']))
                return $this->adminPrompt("操作失败", '信息必须填写完整，请反回重试', $query['from']);
            else
                return $this->adminPrompt("操作失败", '信息必须填写完整，请反回重试', '/admin/examPaper/edit?id='.$query['id']);
        }

        // 处理分类
        $query['sort'] = 0;
        if( !empty($query['sort5']) )
            $query['sort'] = $query['sort5'];
        elseif( !empty($query['sort4']) )
            $query['sort'] = $query['sort4'];
        elseif( !empty($query['sort3']) )
            $query['sort'] = $query['sort3'];
        elseif( !empty($query['sort2']) )
            $query['sort'] = $query['sort2'];
        elseif( !empty($query['sort1']) )
            $query['sort'] = $query['sort1'];

        $ep = new ExamPaper();
        $ep->edit($query);

        if(isset($query['from']))
        {
            //return $this->adminPrompt("操作成功", '提交编辑成功', $query['from']);
            return Redirect::to($query['from']);
        }
        else
            return $this->adminPrompt("操作成功", '提交编辑成功', '/admin/examPaper');
	}

    /* 删除分类并且一并删除对应的题目列表 */
    public function doDel()
    {
        $id = Input::get('id');
        $ep = new ExamPaper();
        $ep->del($id);

        if( !empty(Input::get('ajax')) ) 
            exit("1");
        else
            return $this->adminPrompt("操作成功", '删除成功');
    }

	public function editStatus()
	{
		$query = Input::only('id', 'status', 'ajax');
        $validator = Validator::make($query,
            array(
                'status' => 'numeric|required',
                'id' => 'numeric|required',
            )
        );

        if($validator->fails())
        {
        	if($query['ajax'])
        		exit('0');
        	else
        		return $this->adminPrompt("操作失败", 'ID错误，请反回重试');
        }

        $ep = new ExamPaper();
        $ep->edit($query);

        if($query['ajax'])
        	exit('1');
    	else
    		return $this->adminPrompt("操作成功", '试卷状态修改成功');
	}

	/* 显示添加题干页面 */
	public function showChild()
	{
		$parent_id = Input::get('parent_id');  //所属父类id
		$parent = ExamPaper::find($parent_id);

		// $column = Column::find($parent->column_id);
  //       $paths = array_reverse($column->getPath($column->id));


		return $this->adminView('examPaper.child', compact('column', 'parent', 'paths') );
	}

    public function editClist()
    {
        $id = Input::get('id');
        $info = ExamPaper::find($id);

        $parent = ExamPaper::find($info->parent_id);

        // $column = Column::find($info->column_id);
        // $paths = array_reverse($column->getPath($column->id));


        return $this->adminView('examPaper.child', compact('column', 'paths', 'parent', 'info') );
    }

    /* 试卷题目列表 */
    public function showQlist()
    {
        $id = Input::get('id');

        $ep = new ExamPaper();
        $info = $ep->find($id);

        $parent = $ep->find($info->parent_id);
        // $column = Column::find($info->column_id);
        // $paths = array_reverse($column->getPath($column->id));
        $list = $ep->getQuestions($id);
        
        return $this->adminView('examPaper.question', compact('column', 'paths', 'parent', 'info', 'list') );
    }

    /* 显示对应科目的试卷列表 */
    public function showColumn()
    {
        $column_id = Input::get('column_id');
        $lists = ColumnExamRelation::where('column_id', '=', $column_id)->get();

        $column = Column::find($column_id);
        $paths = array_reverse($column->getPath($column->id));

        return $this->adminView('examPaper.column', compact('column_id', 'lists', 'paths'));
    }

    public function showAddColumn()
    {
        $query = Input::only('sort1','sort2','sort3','sort4','sort5','name', 'column_id');
        $query['status'] = 1;  // 只显示通过的

        $query['sort'] = 0;
        if( !empty($query['sort5']) )
            $query['sort'] = $query['sort5'];
        elseif( !empty($query['sort4']) )
            $query['sort'] = $query['sort4'];
        elseif( !empty($query['sort3']) )
            $query['sort'] = $query['sort3'];
        elseif( !empty($query['sort2']) )
            $query['sort'] = $query['sort2'];
        elseif( !empty($query['sort1']) )
            $query['sort'] = $query['sort1'];

        // 显示列表
        $ep = new ExamPaper();
        $lists = $ep->getElist($query)->paginate(30);
        //var_dump( DB::getQueryLog() );

        $statusEnum = $this->statusEnum;
        $statusEnum = array('' => '所有状态') + $statusEnum;

        $column = Column::find($query['column_id']);
        $paths = array_reverse($column->getPath($column->id));

        return $this->adminView('examPaper.addColumn', compact('query', 'lists', 'statusEnum', 'paths') );
    }

    public function doEditQuestion()
    {
        $query = Input::all();

        if( is_numeric($query['id']) && is_numeric($query['ordern']) )
        {
            ExamQuestionRelation::where('id', '=', $query['id'])->update( array('ordern' => $query['ordern']) );
        }

        return Redirect::to($query['from']);
    }

}
