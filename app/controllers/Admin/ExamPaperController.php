<?php namespace Admin;
use View;
use Session;
use Input;
use Column;
use ExamPaper;
use Validator;
use Redirect;

class ExamPaperController extends \BaseController {

	public function index()
	{
		$columnId = Input::get('column_id');

		$parent = Column::find($columnId);
        $paths = array_reverse($parent->getPath($parent->id));

		return $this->adminView('examPaper.index', compact('parent', 'paths', 'columnId') );
	}

	public function showAdd()
	{
		$columnId = Input::get('column_id');

		$parent = Column::find($columnId);
        $paths = array_reverse($parent->getPath($parent->id));

		return $this->adminView('examPaper.add', compact('parent', 'paths', 'columnId') );
	}

	public function doAdd()
	{
		$query = Input::only('title', 'column_id', 'status', 'price', 'desc');
        $validator = Validator::make($query,
            array(
                'title' => 'alpha_dash|required',
                'column_id' => 'numeric|required',
            )
        );

        if($validator->fails())
        {
            return Redirect::to('/admin/examPaper/add?column_id='.$query['column_id'])->withErrors($validator)->withInput($query);
        }

        $ep = new ExamPaper();
        $ep->add($query);

        return Redirect::to('/admin/column?parent_id='.$query['column_id']);
	}
}
