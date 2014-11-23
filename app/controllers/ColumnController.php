<?php

class ColumnController extends BaseController
{
    public $pageSize = 10;

	public function __construct()
    {
        $query = Input::only('column_id');
// dd(Request::path());
        if ((!isset($query['column_id']) || !is_numeric($query['column_id'])) && Request::path() != 'column/static') {
            echo ("<script>window.location.href='/column/static';</script>");
        }
    }

	public function index()
	{
        $query = Input::only('id', 'column_id', 'page');

        $color = array("#2fc8d0","#efc825","#5fc1e8","#f28695","#f49543","#abd663","#b18ac1");

        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern','ASC')->get();

        if(empty($columns[0]))
            return $this->indexPrompt("", '科目下没有信息', $url = "/column/static", false);

        if (empty($query['id'])) {
            $query['id'] = $columns[0]['id'];
        }

        $column = Column::find($query['id']);
        // 如果是真题试卷或模拟试卷
        if($column->type == 2 || $column->type == 6)
        {
            $content = ColumnExamRelation::where('column_id', '=', $query['id'])->get();
            foreach ($content as $key => $c) {
                //$c->bgcolor = $color[array_rand($color)];
                $content[$key] = $c;
            }
        } elseif ($column->type == 3) {
            //多媒体教材类型
            return Redirect::to('/courseware?id='.$query['id'].'&column_id=' . $column->parent_id . '&type=2');

        } elseif ($column->type == 5) {
            //多媒体教材类型
            return Redirect::to('/games?id='.$query['id'].'&column_id=' . $column->parent_id);

        }
        else {
            $content = $column->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
            //dd(DB::getQueryLog());

            foreach ($content as $key => $c) {
                $c->bgcolor = $color[array_rand($color)];
                $content[$key] = $c;
            }

            // $questions = $column->questions->paginate($this->pageSize);
            // // 当前页数
            if( !is_numeric($query['page']) || $query['page'] < 1 )
                $query['page'] = 1;
            $column_questions = ColumnQuestionRelation::whereColumnId($query['id'])->paginate($this->pageSize);
    		$att = new Attachments();
    		foreach ($column_questions as $key => $r) {
                if(!empty($r->question->img))
                {
    	           $item = $att->get($r->question->img);
    			   $route = $att->getTopicRoute($r->question->id, $item['file_name']);
    			   $r->question->img_url = $route['url'];
                }

    			$questions[$key] = $r->question;
    		}
        }
        if ($column->parent->id != $query['column_id']) {
            $back_url = 1;
        } else {
            $back_url = 0;
        }
        // 获取父类名页面显示
        $cn = new Column();
        $arr = $cn->getPath($query['column_id']);
        $columnHead = $arr[0];

        return $this->indexView('column.' . $column->type, compact('column', 'content', 'columns', 'query', 'questions', 'columnHead', 'back_url', 'column_questions'));
	}

    /* 科目临时显示 */
    public function tmpShow()
    {
        return $this->indexView('profile.column');
    }
}
