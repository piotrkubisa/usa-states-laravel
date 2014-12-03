<?php

class AdminUserController extends Controller {
    
    public function getUsers()
    {
        $users =  User::select(
                    'users.id as id',
                    'users.first_name as first_name',
                    'users.email as email',
                    'users.last_login as last_login',
                    'users.activated as activated' /*,
                    'groups.id as groupId',
                    'groups.name as groupName' */
                )
                ->leftJoin('users_groups', 'users.id', '=', 'user_id')
                ->leftJoin('groups', 'group_id', '=', 'groups.id')
                ->groupBy('users.id');
        
        
        if(isset($_GET['actionResetFilter'])) {
    		return Redirect::to('/admin/users');
    	}
        
        if ((int)Input::get('filterUser')) {
            $users->where('users.id', '=', (int)Input::get('filterUser'));
        }
        
        if (Input::get('filterUsername') !== null) {
            $username = Input::get('filterUsername');
            $username = str_replace("*", "%", $username);
            $users->where('users.first_name', 'LIKE', "%".$username."%");
        }
        
        
        if ((int)Input::get('filterGroup')>0) {
            $users->where('groups.id', '=', (int)Input::get('filterGroup'));
        }
        
        if (Input::get('filterActive') !== null) {
            $active = Input::get('filterActive');
            if ($active=="1") {
                $users->where('users.activated', '=', '1');
            } elseif($active==="0") {
                $users->where('users.activated', '=', '0');
            }
        }
        
        if (Input::get('orderBy')) {
            $orderBy = Input::get('orderBy');
            $order_type = (Input::get('order_type')==0)
                ? "desc"
                : "asc";
            $users->orderBy($orderBy, $order_type);
        }
        
        try {
            $users = $users->paginate(10);
            $groups = Group::all();
        } catch(Exception $e) {
            //return Redirect::to('/admin/users');
        }

        return View::make('admin.users')
            ->with('user', Sentry::getUser())
            ->with('active', 'users')
            ->with('groups', $groups)
            ->with('users', $users);
    }
    
    public function getUser($user_id)
    {
        try {
            $usr = User::where('id', '=', (int)$user_id)->firstOrFail();
            $sentryUsr = Sentry::findUserByID($user_id);
            return View::make('admin.user')
                ->with('user', Sentry::getUser())
                ->with('usr', $usr)
                ->with('groups', Group::all())
                ->with('permissions', Permission::getPermissions())
                ->with('perms', $sentryUsr->getPermissions())
                ->with('permsMerged', $sentryUsr->getMergedPermissions())
                ->with('sentryUsr', $sentryUsr)
                ->with('active', 'users');
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return View::make('admin.user')
                ->with('user', Sentry::getUser())
                ->withErrors(array('message' => 'User not found.'))
                ->with('active', 'users');
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return View::make('admin.user')
                ->with('user', Sentry::getUser())
                ->withErrors(array('message' => 'User not found.'))
                ->with('active', 'users');
        }
    }
    
    public function postUser($user_id)
    {
        $action = Input::get('action');
        try {
            $user = Sentry::getUser();
            $sentryUser = Sentry::findUserById($user_id);
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return Redirect::to('/admin/user')
                ->withErrors(array('message' => 'User not found.'));
        }
        
        switch($action) {
            case 'grantPermissions':
                if(!$user->hasAccess("admin.user.grantPermissions")) {
                    return Redirect::to('/admin/dashboard')->withErrors(array('message' => 'Access denied for resource.'));
                } else {
                    return $this->actionGrantPermissions($sentryUser, $user_id);
                }
                break;
            case 'removeFromGroup':
                if(!$user->hasAccess("admin.user.manageGroups")) {
                    return Redirect::to('/admin/dashboard')->withErrors(array('message' => 'Access denied for resource.'));
                } else {
                    return $this->actionRemoveFromGroup($sentryUser, $user_id);
                }
                break;
            case 'assignToGroup':
                if(!$user->hasAccess("admin.user.manageGroups")) {
                    return Redirect::to('/admin/dashboard')->withErrors(array('message' => 'Access denied for resource.'));
                } else {
                    return $this->actionAssignToGroup($sentryUser, $user_id);
                }
                break;
        }
        
        return Redirect::to('/admin/users')
            ->withErrors(array('message' => 'User cannot be updated.'));
    }
    
    private function actionGrantPermissions($sentryUser, $user_id) 
    {
        $post = Input::get();
        $flatPms = Permission::flatPermissions();
        $permissions = $sentryUser->getMergedPermissions();
        foreach($permissions as $pm => $pmVal) {
            if($pm == "users" || $pm == "admin") continue;
            
            $value = ( isset($post[str_replace('.', '_', $pm)]) ) 
                    ? $post[str_replace('.', '_', $pm)]
                    : $pmVal;
            $permissions[$pm] = $value;
        }
        
        $sentryUser->permissions = $permissions;
	    if($sentryUser->save()) {
	        return Redirect::to('/admin/user/' . (int)$user_id)
	            ->with('successAlerts', array('message' => 'User has been updated successfully.'));
	    } else {
	        return Redirect::to('/admin/user/' . (int)$user_id)
	            ->withErrors(array('message' => 'User cannot be updated.'));
	    }
    }
    
    private function actionAssignToGroup($sentryUser, $user_id) 
    {
        try {
            $groupId = Input::get('groupIdAssign');
            $adminGroup = Sentry::findGroupById((int)$groupId);
            
    	    if($sentryUser->addGroup($adminGroup)) {
    	        return Redirect::to('/admin/user/' . (int)$user_id)
    	            ->with('successAlerts', array('message' => 'User has been updated successfully.'));
    	    } else {
    	        return Redirect::to('/admin/user/' . (int)$user_id)
    	            ->withErrors(array('message' => 'User cannot be updated.'));
    	    }
        } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            return Redirect::to('/admin/user/' . (int)$user_id)
    	        ->withErrors(array('message' => 'User cannot be updated.'));
        }
    }
    
    private function actionRemoveFromGroup($sentryUser, $user_id) 
    {
        try {
            $groupId = Input::get('groupIdRemove');
            $adminGroup = Sentry::findGroupById((int)$groupId);
            
    	    if($sentryUser->removeGroup($adminGroup)) {
    	        return Redirect::to('/admin/user/' . (int)$user_id)
    	            ->with('successAlerts', array('message' => 'User has been updated successfully.'));
    	    } else {
    	        return Redirect::to('/admin/user/' . (int)$user_id)
    	            ->withErrors(array('message' => 'User cannot be updated.'));
    	    }
        } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            return Redirect::to('/admin/user/' . (int)$user_id)
    	        ->withErrors(array('message' => 'User cannot be updated.'));
        }
    }
    
    public function getUserDelete($user_id)
    {
    	try {
    	    $user = Sentry::findUserById((int)$user_id);
    	    if($user->delete()) {
    	        return Redirect::to('/admin/users')
    	            ->with('successAlerts', array('message' => 'User has been deleted successfully.'));
    	    } else {
    	        return Redirect::to('/admin/users')
    	            ->withErrors(array('message' => 'User cannot be deleted.'));
    	    }
    	} catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
    	    return Redirect::to('/admin/users')
    	        ->withErrors(array('message' => 'User not found.'));
    	} catch (Exception $e) {
	        return Redirect::to('/admin/scores')
    	        ->withErrors(array('message' => 'User cannot be deleted.'));
    	}
    }
    
    public function getUserActivate($user_id)
    {
    	if (null !== Input::get('value')) {
    		$value = (int)Input::get('value');
		    
		    try {
		        $user = User::findOrFail((int)$user_id);
		        $user->activated = (int)$value;
		        
		        if($user->save()) {
	            	return Redirect::to('/admin/users')
                        ->with('successAlerts', array('message' => 'User has been updated successfully.'));
		        } else {
		            return Redirect::to('/admin/users')
    	                ->withErrors(array('message' => 'User cannot be updated.'));
		        }
		    }  catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        	    return Redirect::to('/admin/users')
        	        ->withErrors(array('message' => 'User not found.'));
		    } catch (Exception $e) {
    	        return Redirect::to('/admin/users')
        	        ->withErrors(array('message' => 'User cannot be updated.'));
		    }
    	}
    }
}