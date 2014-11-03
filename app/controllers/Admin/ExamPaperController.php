<?php namespace Admin;
use View;
use Session;
use Input;
use Column;
use ExamPaper;
use Validator;
use Redirect;
use ExamQuestionRelation;

class ExamPaperController extends \BaseController {

	public $statusEnum = array('0' => '未审核', '1' => '上线', '-1' => '下线');

	public function index()
	{
		$columnId = Input::get('column_id');

		$parent = Column::find($columnId);
        $paths = array_reverse($parent->getPath($parent->id));

        // 显示列表
        $ep = new ExamPaper();
        $lists = $ep->getExamList( $columnId );

        $statusEnum = $this->statusEnum;

		return $this->adminView('examPaper.index', compact('parent', 'paths', 'columnId', 'lists', 'statusEnum') );
	}

	public function showAdd()
	{
		$columnId = Input::get('column_id');

		$parent = Column::find($columnId);
        $paths = array_reverse($parent->getPath($parent->id));

		return $this->adminView('examPaper.add', compact('parent', 'paths', 'columnId') );
	}

	public function showEdit()
	{
		$id = Input::get('id');
		$info = ExamPaper::find($id);

		$parent = Column::find($info->column_id);
        $paths = array_reverse($parent->getPath($parent->id));

        $columnId = $info->column_id;

		return $this->adminView('examPaper.add', compact('parent', 'paths', 'columnId', 'info') );
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

		$parent = Column::find($info->column_id);
        $paths = array_reverse($parent->getPath($parent->id));

		return $this->adminView('examPaper.clist', compact('info', 'lists', 'parent', 'paths', 'lists') );
	}

	public function doAdd()
	{
		$query = Input::all();
        $validator = Validator::make($query,
            array(
                'title' => 'alpha_dash|required',
                'column_id' => 'numeric|required',
            )
        );

        if($validator->fails())
        {
            //return Redirect::to('/admin/examPaper/add?column_id='.$query['column_id'])->withErrors($validator)->withInput($query);
            if(isset($query['from']))
                return $this->adminPrompt("操作失败", '信息必须填写完整，请反回重试', $query['from']);
            else
                return $this->adminPrompt("操作失败", '信息必须填写完整，请反回重试', '/admin/examPaper/add?column_id='.$query['column_id']);
        }

        $ep = new ExamPaper();
        $ep->add($query);

        //return Redirect::to('/admin/column?parent_id='.$query['column_id']);

        if(isset($query['from']))
            return $this->adminPrompt("操作成功", '提交编辑成功', $query['from']);
        else
            return $this->adminPrompt("操作成功", '提交编辑成功', '/admin/column?parent_id='.$query['column_id']);
	}

	public function doEdit()
	{
		$query = Input::all();
        $validator = Validator::make($query,
            array(
                'title' => 'alpha_dash|required',
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

        $ep = new ExamPaper();
        $ep->edit($query);

        if(isset($query['from']))
            return $this->adminPrompt("操作成功", '提交编辑成功', $query['from']);
        else
            return $this->adminPrompt("操作成功", '提交编辑成功', '/admin/column?parent_id='. $query['column_id']);
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

		$column = Column::find($parent->column_id);
        $paths = array_reverse($column->getPath($column->id));


		return $this->adminView('examPaper.child', compact('column', 'parent', 'paths') );
	}

    public function editClist()
    {
        $id = Input::get('id');
        $info = ExamPaper::find($id);

        $parent = ExamPaper::find($info->parent_id);

        $column = Column::find($info->column_id);
        $paths = array_reverse($column->getPath($column->id));


        return $this->adminView('examPaper.child', compact('column', 'paths', 'parent', 'info') );
    }

    /* 试卷题目列表 */
    public function showQlist()
    {
        $id = Input::get('id');

        $ep = new ExamPaper();
        $info = $ep->find($id);

        $parent = $ep->find($info->parent_id);
        $column = Column::find($info->column_id);
        $paths = array_reverse($column->getPath($column->id));

        $list = ExamQuestionRelation::where('exam_id', '=', $id)->get();

        return $this->adminView('examPaper.question', compact('column', 'paths', 'parent', 'info', 'list') );
    }
}
