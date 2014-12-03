<?php

class SentrySeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
	    /* Table:Users
	     ===================*/
	     
	    // Truncate
		DB::table('users')->truncate();
		
		// Add sample users
		Sentry::getUserProvider()->create(array(
	        'email'    => 'admin@admin.com',
	        'password' => 'admin1234',
	        'first_name' => 'admin',
	        'activated' => 1,
	    ));
	    Sentry::getUserProvider()->create(array(
	        'email'    => 'user@user.com',
	        'password' => 'user1234',
	        'first_name' => 'user',
	        'activated' => 1,
	    ));
	    
	    /* Table:Users
	     ===================*/
	    
	    // Truncate
		DB::table('groups')->truncate();
		
		Sentry::getGroupProvider()->create(array(
	        'name'        => 'Users',
	        'permissions' => array(
	            'users' => 1,
	            'admin' => 0,
	            'admin.score.view' => 0,
	            'admin.score.delete' => 0,
				'admin.user.view' => 0,
				'admin.user.activate' => 0,
				'admin.user.delete' => 0,
				'admin.user.update' => 0,
				'admin.user.manageGroups' => 0,
				'admin.user.grantPermissions' => 0,
	        )));
		Sentry::getGroupProvider()->create(array(
	        'name'        => 'Admins',
	        'permissions' => array(
	            'users' => 1,
	            'admin' => 1,
	            'admin.score.view' => 1,
	            'admin.score.delete' => 1,
				'admin.user.view' => 1,
				'admin.user.activate' => 1,
				'admin.user.delete' => 1,
				'admin.user.update' => 1,
				'admin.user.manageGroups' => 1,
				'admin.user.grantPermissions' => 1,
	        )));

	    /* Table:UsersGroups
	     ===================*/
	    
	    // Truncate
	    DB::table('users_groups')->truncate();
	    
		$userUser = Sentry::getUserProvider()->findByLogin('user@user.com');
		$adminUser = Sentry::getUserProvider()->findByLogin('admin@admin.com');
		$userGroup = Sentry::getGroupProvider()->findByName('Users');
		$adminGroup = Sentry::getGroupProvider()->findByName('Admins');
		
	    // Assign the groups to the users
	    $userUser->addGroup($userGroup);
	    $adminUser->addGroup($userGroup);
	    $adminUser->addGroup($adminGroup);
	}
}
