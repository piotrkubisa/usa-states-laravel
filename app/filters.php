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
	//
});


App::after(function($request, $response)
{
	//
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
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});



/* Sentry filters
 ====================*/
 
 
Route::filter('Sentry', function() {
    if (!Sentry::check()) {
        throw new Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        //return Redirect::to('/');
    }
});

Route::filter('hasAccess', function($route, $request, $value) {
    try {
        $user = Sentry::getUser();
    
        if(!$user->hasAccess($value)) {
            return Redirect::to('/admin/dashboard')->withErrors(array('message' => 'Access denied for resource.'));
        }
    }
    catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
        throw new Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
    }
});

Route::filter('inGroup', function($route, $request, $value) {
    try {
        $user = Sentry::getUser();
        $group = Sentry::findGroupByName($value);
    
        if(!$user->inGroup($group)) {
            throw new Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }
    } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
        throw new Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
    } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
        throw new Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
    }
});