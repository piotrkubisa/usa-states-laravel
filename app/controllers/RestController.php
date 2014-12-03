<?php

class RestController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Rest Controller
	|--------------------------------------------------------------------------
	|
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
    
	public function showWelcome()
	{
		return View::make('hello');
	}
    
    public function getStates()
    {
        return Response::json(State::all());    
    }
    
    public function getMap()
    {
        return file_get_contents(__DIR__.'/../storage/us.json');
    }
    
    public function postCheck()
    {
        $post = Input::get('username', 'password', 'password_confirmation', 'email');
        $reponse = User::validateSignup($post);
        return Response::json($response);
    }
    
    public function postCheckUsername()
    {
        $name = array('username' => Input::get('username'));
        $rules = User::getValidateRules();
        
        $rule = array(
            'username' => $rules['username']
        );
        
        return User::validateField('username', $name, $rule);
    }
    
    public function postCheckEmail()
    {
        $name = array('email' => Input::get('email'));
        $rules = User::getValidateRules();
        
        $rule = array(
            'email' => $rules['email']
        );
        
        return User::validateField('email', $name, $rule);
    }
    
    public function getScores()
    {
        $type = Input::get('type');
        $scores = Score::getData();
        
        return Response::json(
            $scores
        );
    }
    
    public function postScores()
    {
        try {
            if(Sentry::check()) {
                $user = Sentry::getUser();
            }
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $user = null;
        } catch (Exception $e) {
            $user = null;
        }
        
        if(empty($user)) {
            return Response::json('Only registered users', 403);
        }
            
        $post = Input::only('targetPoints', 'guesses', 'start_time', 'end_time');
        
        $score = new Score();    
        $score->user_id = $user->id;
        $score->guesses = $post['guesses'];
        $score->points_to_check = $post['targetPoints'];
        $score->start_date = $post['start_time'];
        $score->end_date = $post['end_time'];
        $result = $score->save();
        
        return Response::json( 
            $result
        );
    }
    
}
