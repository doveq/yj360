<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	
});


App::after(function($request, $response)
{
	// 记着密码登录的账户设置session
	if(Auth::viaRemember() && empty(Session::get('uid')))
	{
		$user = Auth::user();
		Session::put('uid', $user->id);
		Session::put('uname', $user->name);
		Session::put('utype', $user->type);
		Session::put('utel', $user->tel);
	}

	//
	if( Auth::check() ) {
		Session::put('newmassage_count', User::find(Session::get('uid'))->receiver()->whereStatus(0)->count());
		$log             = new UserLog();
		$log->user_id    = Session::get('uid');
		$log->ip         = Request::getClientIp();
		$log->url        = Request::fullUrl();
		$log->referer    = Request::header('referer');
		$log->method     = Request::method();
		$log->code       = 200;
		$log->created_at = date("Y-m-d H:i:s");
		$log->user_agent = Request::header('user-agent');
		$log->type       = 1;
		$log->save();
	}
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});



DB::listen(function($sql, $bindings, $time)
{
    Log::info('[SQL]' . $sql . " with ". join(',', $bindings));
});