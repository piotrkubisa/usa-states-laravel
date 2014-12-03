<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
| -- Comment
| Especially for this project I don't use a controller-based 
| route mapping which is extremaly helpful.
*/

Route::get('/hello', function() {
    return View::make('hello');
});

Route::get('/', function() {
    // reflash it for /partials
    Session::reflash();
    return View::make('layout');
});

Route::get('/partials/{template}', function($template) {
    $template_name = "templates.intro";
    switch ($template) {
        case 'map':
            $template_name = 'templates.map';
            break;
        case 'signup':
            $template_name = 'templates.signup';
            break;
        case 'highscores':
            $template_name = 'templates.highscores';
            break;
    }
    
    $user = null;
    try {
        if(Sentry::check()) {
            $user = Sentry::getUser();
        }
            
    } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
        $user = null;
    } catch (Exception $e) {
        $user = null;
    }
    
    return View::make($template_name)
        ->with('user', $user);    
});

/* RestController
 ======================*/
Route::get('/rest/states', 'RestController@getStates');
Route::get('/rest/map', 'RestController@getMap');
Route::post('/rest/check', 'RestController@postCheck');
Route::post('/rest/check/username', 'RestController@postCheckUsername');
Route::post('/rest/check/email', 'RestController@postCheckEmail');
Route::get('/rest/scores', 'RestController@getScores');
Route::post('/rest/scores', 'RestController@postScores');

/* AuthController
 ======================*/
Route::post('/auth/signup', 'AuthController@postSignup');
Route::post('/auth/login', 'AuthController@postLogin');

Route::get('auth/logout', function() {
    Sentry::logout();
    return Redirect::to('/');
});


/**
 * @uses PHP Excel
 * PHPExcel_Cell::stringFromColumnIndex(1)
 */
Route::get('/render/pdf', 'RenderController@getPdf');
Route::get('/render/xls', 'RenderController@getXls');
Route::get('/render/xlsx', 'RenderController@getXlsx');

Route::group(array('prefix' => 'admin', 'before' => 'Sentry|inGroup:Admins|hasAccess:admin'), function()
{
    Route::get('/', function() {
        return Redirect::to('/admin/dashboard');
    });
    
    Route::get('/dashboard', function() {
        return View::make('admin.dashboard')
            ->with('user', Sentry::getUser())
            ->with('active', 'dashboard')
            ->with('userCount', User::count())
            ->with('scoreCount', Score::count());
    });
    
    Route::get('/users', array('uses' => 'AdminUserController@getUsers'))->before('hasAccess:admin.user.view');
    Route::get('/user/{user_id}', array('uses' => 'AdminUserController@getUser'))->before('hasAccess:admin.user.view');
    Route::get('/user/{user_id}/delete', array('uses' => 'AdminUserController@getUserDelete'))->before('hasAccess:admin.user.delete');
    Route::get('/user/{user_id}/activate', array('uses' => 'AdminUserController@getUserActivate'))->before('hasAccess:admin.user.activate');
    Route::post('/user/{user_id}', array('uses' => 'AdminUserController@postUser'))->before('hasAccess:admin.user.update');
    
    Route::get('/scores',  array('uses' => 'AdminScoreController@getScores'))->before('hasAccess:admin.score.view');
    Route::get('/score/{score_id}', array('uses' => 'AdminScoreController@getScore'))->before('hasAccess:admin.score.view');
    Route::get('/score/{score_id}/delete', array('uses' => 'AdminScoreController@getScoreDelete'))->before('hasAccess:admin.score.delete');

});


App::missing(function($exception) {
    return Response::view('errors.missing', array(), 404);
});
