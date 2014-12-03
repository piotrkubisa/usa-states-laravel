<?php

class Score extends Eloquent {

	protected $table = 'scores';
    const SQL_LIMIT = 10;
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	// protected $hidden = array('password', 'remember_token');
	
	public function user()
    {
        return $this->belongsTo('User');
    }
    
    public static function prepare()
    {
         return self::join('users', 'scores.user_id', '=', 'users.id')
            ->select(
                'users.first_name as username',
                'users.email',
                'scores.start_date',
                'scores.end_date',
                'scores.guesses',
                // it could be categoryGameId or something like this 
                'scores.points_to_check',
                'scores.created_at',
                DB::raw("TIMEDIFF(end_date, start_date) as time_diff")
            )
            ->orderBy('guesses', 'asc')
            ->orderBy(DB::raw("TIMEDIFF(end_date, start_date)"), 'asc');
    }
    
    /**
     * Deprecated.
     */
    public static function getByType($type = null)
    {
        $scores = self::prepare();      
    
        switch($type) {
            case "guesses":
                $scores->orderBy('guesses');
                break;
            case "time":
                $scores->orderBy(DB::raw("TIMEDIFF(end_date, start_date)"));
                break;
            default:
                $scores->orderBy('guesses', 'asc');
                $scores->orderBy(DB::raw("TIMEDIFF(end_date, start_date)"), 'asc');
                break;
        }
        
        $data = $scores->get()->take(self::SQL_LIMIT);
        
        for($i = 0; $i < count($data); $i++) {
            $data[$i]['avatar'] = Gravatar::src($data[$i]['email'], 48);
        }
        
        return $data;
    }
    
    public static function getByTargetPoints($targetPoints = 5, $addAvatar = true)
    {
        $score = self::prepare()->where('scores.points_to_check', '=', (int)$targetPoints);
        $data = $score->get()->take(self::SQL_LIMIT);
        
        if($addAvatar === true) {
            for($i = 0; $i < count($data); $i++) {
                $data[$i]['avatar'] = Gravatar::src($data[$i]['email'], 48);
            }
        }
        
        return $data;
    }
    
    public static function getData()
    {
        $data = array(
            self::getByTargetPoints(5),
            self::getByTargetPoints(10),
            self::getByTargetPoints(50),
        );
        
        
        return $data;
    }        
}
