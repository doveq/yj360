<?php

class ColumnController extends BaseController
{

	public function __construct()
    {
    	//$this->beforeFilter('csrf', array('on' => 'post'));
    }

	/* 登录处理 */
	public function index()
	{
        $query = Input::only('id', 'column_id');
        $color = array("#2fc8d0","#efc825","#5fc1e8","#f28695","#f49543","#abd663","#b18ac1");
        $column = Column::find($query['id']);
        $content = $column->child()->whereStatus(1)->get();
        foreach ($content as $key => $c) {
            // dd($color[array_rand($color)]);
            $c->bgcolor = $color[array_rand($color)];
            $content[$key] = $c;
        }

        if (!isset($query['column_id'])) {
            $query['column_id'] = 5;
        }

        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->get();


        $questions = $column->questions;
		$att = new Attachments();
		foreach ($questions as $key => $q) {
	        $item = $att->get($q->img);
			$route = $att->getTopicRoute($q->id, $item['file_name']);
			// dd($route);
			$q->img_url = $route['url'];
			$questions[$key] = $q;
		}

        return $this->indexView('column.' . $column->type, compact('column', 'content', 'columns', 'query', 'questions'));
	}

}
