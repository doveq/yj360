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

	protected function adminView($layout, $data = array())
	{
		return View::make('Admin.' . $layout, $data);
	}

	protected function indexView($layout, $data = array())
	{
		return View::make('Index.' . $layout, $data);
	}
}
