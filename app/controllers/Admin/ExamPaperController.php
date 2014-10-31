<?php namespace Admin;
use View;
use Session;
use Input;
use Column;

class ExamPaperController extends \BaseController {

	public function index()
	{

		return $this->adminView('index');
	}

	public function showAdd()
	{
		$columnId = Input::get('column_id');

		$parent = Column::find($columnId);
        $paths = array_reverse($parent->getPath($parent->id));

		return $this->adminView('examPaper.add', compact('parent', 'paths', 'columnId') );
	}

}
