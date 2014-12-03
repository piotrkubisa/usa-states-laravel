<?php

class AdminScoreController extends Controller {
    
    public function getScores()
    {
        $scores = DB::table('scores');
        
        if(isset($_GET['actionResetFilter'])) {
            return Redirect::to('/admin/scores');
        }
        
        if ((int)Input::get('filterId')) {
            $scores->where('scores.id', '=', (int)Input::get('filterId'));
        }

        if (Input::get('filterUsername') !== null) {
            $username = Input::get('filterUsername');
            $username = str_replace("*", "%", $username);
            $scores->where('users.first_name', 'LIKE', "%".$username."%");
        }
        
        if ((int)Input::get('filterTargetPoints')>0) {
            $scores->where('scores.points_to_check', '=', (int)Input::get('filterTargetPoints'));
        }        
   
        if (Input::get('orderBy')) {
            $orderBy = Input::get('orderBy');
            $order_type = (Input::get('order_type')==0)
                ? "desc"
                : "asc";
            $scores->orderBy($orderBy, $order_type);
            $filterParams['orderBy'] = $orderBy;
            $filterParams['order_type'] = (int)Input::get('order_type');
        }
        
        try {
            $scores = $scores
                ->leftJoin('users', 'users.id', '=', 'user_id')
                ->select(
                    'users.first_name',
                    'users.email',
                    'scores.id',
                    'scores.user_id',
                    'scores.start_date',
                    'scores.end_date',
                    'scores.guesses',
                    // it could be categoryGameId or something like this 
                    'scores.points_to_check',
                    'scores.created_at',
                    DB::raw("TIMEDIFF(end_date, start_date) as time_diff")
                )->paginate(10);
        } catch(Exception $e) {
            return Redirect::to('/admin/scores');
        }

        return View::make('admin.scores')
            ->with('user', Sentry::getUser())
            ->with('scores', $scores)
            ->with('active', 'scores');
    }
    
    public function getScore($score_id)
    {
        try {
            $score = Score::where('id', '=', (int)$score_id)->firstOrFail();
            
            return View::make('admin.score')
                ->with('user', Sentry::getUser())
                ->with('score', $score)
                ->with('active', 'scores');
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return View::make('admin.score')
                ->with('user', Sentry::getUser())
                ->with('active', 'scores')
                ->withErrors(array('message' => 'Score not found.'));
        }
    }
    
    public function getScoreDelete($score_id)
    {
    	try {
    	    $score = Score::findOrFail((int)$score_id);
    	    if($score->delete()) {
    	        return Redirect::to('/admin/scores')
    	            ->with('successAlerts', array('message' => 'Score has been deleted successfully.'));
    	    } else {
    	        return Redirect::to('/admin/scores')
    	            ->withErrors(array('message' => 'Score cannot be deleted.'));
    	    }
    	} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    	    return Redirect::to('/admin/scores')
    	        ->withErrors(array('message' => 'Score not found.'));
    	} catch (Exception $e) {
	        return Redirect::to('/admin/scores')
    	        ->withErrors(array('message' => 'Score cannot be deleted.'));
    	}
    	
    }
}