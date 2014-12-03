<?php

class Permission {

	public static function getPermissions()
	{
	    return array(
            'users' => array(),
            'admin' => array(
                'score' => array(
                    'view',
                    'delete',
                ),
                'user' => array(
                    'view',
                    'delete',
                    'activate',
                    'update',
                    'manageGroups',
                    'grantPermissions',
                )
            )
        );
	}
	
	public static function flatPermissions()
	{
	    $permissions = self::getPermissions();
	    $arr = array();
	    
        foreach($permissions as $pm_group => $pm_groupVal) {
            // group
            array_push($arr, $pm_group);
            
            foreach($pm_groupVal as $pm_area => $pm_areaVal) {
                foreach($pm_areaVal as $pm) {
                    $pm_path = $pm_group.'.'.$pm_area.'.'.$pm;
                    array_push($arr, $pm_path);
                }
            }
        }
        
        return $arr;
	}
}
