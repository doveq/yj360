<?php

class ColumnController extends BaseController
{

	public function __construct()
    {
    	//$this->beforeFilter('csrf', array('on' => 'post'));
    }

	public function index()
	{
        $query = Input::only('id', 'column_id');

        $color = array("#2fc8d0","#efc825","#5fc1e8","#f28695","#f49543","#abd663","#b18ac1");

        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern','ASC')->get();

        if(empty($columns[0]))
            return $this->indexPrompt("", '科目下没有信息', $url = "/column/static", false);

        if (empty($query['id'])) {
            $query['id'] = $columns[0]['id'];
        }

        $column = Column::find($query['id']);

        // 如果是试卷类型
        if($column->type == 2)
        {
            $content = ColumnExamRelation::where('column_id', '=', $query['id'])->get();
            foreach ($content as $key => $c) {
                //$c->bgcolor = $color[array_rand($color)];
                $content[$key] = $c;
            }
        }
        else
        {
            $content = $column->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
            foreach ($content as $key => $c) {
                // dd($color[array_rand($color)]);
                $c->bgcolor = $color[array_rand($color)];
                $content[$key] = $c;
            }


            $questions = $column->questions;
    		$att = new Attachments();
    		foreach ($questions as $key => $q) {
    	        $item = $att->get($q->img);
    			$route = $att->getTopicRoute($q->id, $item['file_name']);
    			// dd($route);
    			$q->img_url = $route['url'];
    			$questions[$key] = $q;
    		}
        }

        // 获取父类名页面显示
        $cn = new Column();
        $arr = $cn->getPath($query['column_id']);
        $columnHead = $arr[0];

        return $this->indexView('column.' . $column->type, compact('column', 'content', 'columns', 'query', 'questions', 'columnHead'));
	}

    /* 科目临时显示 */
    public function tmpShow()
    {
        return $this->indexView('profile.column');
    }
}
