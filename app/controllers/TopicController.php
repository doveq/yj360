<?php

class TopicController extends BaseController {

	public function index()
	{
		//return View::make('hello');

		return $this->indexView('topic');
	}
}
