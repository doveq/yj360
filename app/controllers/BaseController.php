<?php

class BaseController extends Controller 
{
    
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	protected function adminView($layout)
	{
		return View::make('Admin.' . $layout);
	}

	protected function indexView($layout)
	{
		return View::make('Index.' . $layout);
	}
}
