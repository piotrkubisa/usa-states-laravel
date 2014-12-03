<?php

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function postSignup()
	{
	    $post = Input::only('username', 'password', 'password_confirmation', 'email');
	    Input::flashOnly('username', 'password', 'password_confirmation', 'email');
	    
	    $response = User::validateSignup($post);
	    echo json_encode($response);
	    
	    if ($response['status'] === "error") {
	        Session::flash('validation', $response);
	        return Redirect::to('/#/signup');        
	    }
	    
        $error = '';
        
        try {
            $user = Sentry::register(array(
                'email'    => $post['email'],
                'password' => $post['password'],
                'first_name' => $post['username'],
            ));

            // I would even dare with sending email activation
            $activationCode = $user->getActivationCode();
            $user->attemptActivation($activationCode);
            
            $userGroup = Sentry::getGroupProvider()->findByName('Users');
            $user->addGroup($userGroup);
            
        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            $error = 'Login field is required.';
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            $error = 'Password field is required.';
        } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
            $error = 'User with this login already exists.';
        } catch (Cartalyst\Sentry\Users\UserAlreadyActivatedException $e) {
            $error = 'User is already activated.';
        }
        
        // on.error
        if (!empty($error)) {
            $response['response'] = $error;
            Session::flash('signupError', $error);
            
            return Redirect::to('/#/signup');
        }
        
        Session::flash('signupSuccess', 'yes');
        return Redirect::to('/');        
	}
	
	public function postLogin()
	{
	    $credentials = Input::only('email', 'password');
	    Input::flashOnly('email', 'password');
	    $error = '';
	    
	    try {
	        // Rememeber as false value
	        $user = Sentry::authenticate($credentials, false);
	        
	    } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
	        $error = 'Login field is required.';
	    } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
	        $error = 'Password field is required.';
	    } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
	        $error = 'Wrong password, try again.';
	    } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
	        $error = 'User was not found.';
	    } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
	        $error = 'User is not activated.';
	    }
	    
	    // on.error
	    if (!empty($error)) {
	        Session::flash('loginError', $error);
	        return Redirect::to('/#/signup');
	    }
	
	    Session::flash('loginSuccess', 'yes');
	    return Redirect::to('/');
	}

}
