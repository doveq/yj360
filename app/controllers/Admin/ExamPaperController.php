<?php namespace Admin;
use View;
use Session;

class ExamPaperController extends \BaseController {

	public function index()
	{
		return $this->adminView('index');
	}

	public function showAdd()
	{
		return $this->adminView('examPaper.add');
	}

}
