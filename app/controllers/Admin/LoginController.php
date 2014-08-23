<?php
namespace Admin;
use View;

class LoginController extends \BaseController {

	public function index()
	{
		return View::make('Admin.login');
	}
}
