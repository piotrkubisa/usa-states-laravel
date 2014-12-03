<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
    
    public function groups()
    {
        return $this->belongsToMany('Group', 'users_groups', 'user_id', 'group_id');
    }
    
    public static function getValidateRules()
    {
        return array(
            'username' => 'required|unique:users,first_name|min:5',
            'password' => 'required|confirmed|min:8',
            'email' => 'required|unique:users,email|email',
        );
    }
    
    public static function validateField($field_name, array $value, array $rules)
    {
        $response = array('status' => 'error');
        $validator = Validator::make($value, $rules);    

        if ($validator->fails()) {
            foreach ($validator->messages()->get($field_name) as $message) {
                $response['response'] = $message;
            }

            return Response::json($response, 403);

        } else {
            $response['status'] = 'success';
            $response['response'] = 'ok';

            return Response::json($response);
        }  
    }
    
    public static function validateSignup($data)
    {
        $response = array(
            'status' => 'error',
            'response' => ''
        );
        $rules = User::getValidateRules();
        
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $messages = $validator->messages();
            $errors = array();

            foreach($rules as $rule_cat => $rule) {
                if ($messages->has($rule_cat)) {
                    $errors[$rule_cat] = array();
                    foreach ($messages->get($rule_cat) as $message) {
                        array_push($errors[$rule_cat], $message);
                    }
                }            
           }

            $response['response'] = $errors;
        } else {
            $response['status'] = 'success';
            $response['response'] = 'ok';
        }
        
        return $response;
    }
    
}
