<?php

namespace App\Http\Controllers;
use App\Match;
use App\Bet;
use App\Winner;
use Carbon\Carbon;
use App\Result;
use App\Player;
use App\BetUser;
use App\BetPlayer;
use App\BetPlayerUser;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class BetController extends Controller
{
    public function index()
	{
		$now = Carbon::now();
	    $week= Carbon::now()->subWeek();
		$winners=Winner::all();
		$playersbyteam=Player::orderBy('team')->get(); 
    		
    	if(Auth::check() && Auth::user()->role==1)
    	{	
    		$matchesbydate=Match::with('result')->where('start_date','>',$week)->orderBy('start_date')->get()->groupBy('start_date');    	
    		return view('bet.admin')->with(['matchesbydate'=>$matchesbydate,'now'=>$now,'winners'=>$winners,'playersbyteam'=>$playersbyteam]);	
    	}

    	else
    	{	
    		$matchesbydate=Match::where('start_date','>',$now)->orderBy('start_date')->get()->groupBy('start_date');	
	    	return view('bet.index')->with(['matchesbydate'=>$matchesbydate,'winners'=>$winners,'playersbyteam'=>$playersbyteam]);
    	}
    }

    public function processTeam(Request $request)
	{

		if(!Auth::check())
		{
			echo json_encode('notloggedin');die;
		}

		else if(Auth::check() && $request->all)
		{
			$match=Match::where(['id'=>$request->id])->first();

			if($match->start_date<Carbon::now())
			{
				echo json_encode('dateexpired');die;	
			}

			if($request->team==1)
			{
				$total=$request->price*$request->team1_value;
				$team=$match->team1;

			}
			else if($request->team==2)
			{
				$total=$request->price*$request->team2_value;
				$team=$match->team2;
			}

			$username=Auth::user()->username;
			$email=Auth::user()->email;

			$bet=new Bet();
			$bet->match_id=$request->id;
			$bet->team=$team;
			$bet->price=$request->price;
			$bet->win_price=$total;
			
			if($bet->save())
			{
				$bet_id=$bet->id;
				$betUser=new BetUser();
				$betUser->bet_id=$bet_id;
				$betUser->user_id=Auth::user()->id;
				
				if($betUser->save())
				{

					$message= "Hello $username ($email), your bet on $team on game $match->team1 vs $match->team2, at date $match->start_date with price of Rs $request->price has been set. You will get a total of Rs. $total if $team wins. Thank You and Good Luck!";
					echo json_encode(true);die;
				}
			}
			echo json_encode(FALSE);die;
		}
    }


    public function updateValue(Request $request)
	{
		if(!Auth::check())
		{
			echo json_encode('notloggedin');die;
		}
		
		else if(Auth::user()->role==1)
		{
			if($request->all())
			{
				$match=Match::where(['id'=>$request->id])->first();

				if($match)
				{
					$match->team1=$request->team1;
					$match->team2=$request->team2;
					$match->team1_value=$request->team1_value;
					$match->team2_value=$request->team2_value;
					$match->start_date=$request->start_date;
					
					if($match->update())
					{
						echo json_encode(true);die;
					}
				}
			}	
		}
		else
		{
			echo json_encode('notanadmin');die;	
		}
    }

    public function addMatch(Request $request)
	{

		if(!Auth::check())
		{
			echo json_encode('notloggedin');die;
		}
		
		else if(Auth::user()->role==1 && $request->all())
		{
			if($request->start_date<Carbon::now())
			{
				echo json_encode('dateexpired');die;
			}

			$match=new Match();
			$match->team1=$request->team1;
			$match->team2=$request->team2;
			$match->team1_value=$request->team1_value;
			$match->team2_value=$request->team2_value;
			$match->start_date=$request->start_date;
			if($match->save())
			{
				echo json_encode(TRUE);die;	 
    		}
    	}
    	else
    	{
    		echo json_encode('notanadmin');die;	
    	}
	}

	public function highestScorer(Request $request)
	{

		if(!Auth::check())
		{
			echo json_encode('notloggedin');die;
		}

		if(Auth::check() && $request->all())
		{

			$match=Match::where(['id'=>$request->id])->first();
			if($match)
			{
				if($match->start_date<Carbon::now())
				{
					echo json_encode('dateexpired');die;	
				}

				$username=Auth::user()->username;
				$email=Auth::user()->email;

				$bet=new BetPlayer();
				$bet->match_id=$request->id;
				$bet->player=$request->highest_scorer;

				if($bet->save())
				{
					$betUser=new BetPlayerUser();
					$betUser->bet_id=$bet->id;
					$betUser->user_id=Auth::user()->id;
					
					if($betUser->save())
					{
						$message= "Hello $username ($email), your bet on player $request->highest_scorer on game $match->team1 vs $match->team2, at date $match->start_date has been set. You will get a total of Rs. $total if $team wins. Thank You and Good Luck!";

						echo json_encode(true);die;
					}
				}	
				  echo json_encode(false);die;				
			}
		}
	}


    public function addPlayers(Request $request)
	{

		if(!Auth::check())
		{
			echo json_encode('notloggedin');die;	
		}

		else if(Auth::user()->role==1)
		{
	    	$data=array();
			$players=$request->player_name;
			if($players)
			{
				foreach($players as $player)
				{
					if(!empty($player))
					{	
						$data[]=[
                    		'team' => $request->team,
                    		'player_name' => $player,
                	   	];  
					}
				}
				
				if(Player::insert($data))
				{
					echo json_encode(TRUE);die;
				}	 
			}	
		}
		else
		{
			echo json_encode('notanadmin');die;
		}
	}

	public function result(Request $request)
	{
		if($request->ajax())
		{
			if(!Auth::check())
			{
				echo json_encode('notloggedin');die;
			}
			
			else if(Auth::user()->role==1 && $request->all())
			{
				$match=Match::where(['id'=>$request->id])->first();
				if($match)
				{
					$result=new Result();		
					$result->match_id=$request->id;
				
					if($request->team==1)
					{
						$result->won_by=$match->team1;
					}
					else if($request->team==2)
					{
						$result->won_by=$match->team2;
					}

					$result->highest_scorer=$request->highest_scorer;
					if($result->save())
					{
		 				echo json_encode(TRUE);
		 			}

					$match->with('result','bets','betplayers','bets.users','betplayers.users');
					dd($match);
					
					foreach($match->betplayers as $betplayer)
					{
						if($betplayer->player==$match->result->highest_scorer)
						{
							foreach($betplayer->users as $user)
							{
								$message="hello $user->username, ....";
							}

							$Winner-new WunnerPlayer();
							$winner->username=$user->username;
							$winner->match_id=$match->id;
							$winner->player=$betplayer->player;
							$winner->save();

						}

						else
						{
							foreach($betplayer->users as $user)
							{
					 			$message="hello $user->username .....";
							}
						}
					}
				
					foreach($match->bets as $bet)
					{
						if($bet->team==$match->result->won_by)
						{
							foreach($bet->users as $user)
							{
						
					    		$message="hello $user->username, your bet on $match->team1 vs $match->team2 is completed, and your team $bet->team has won the game. Congratulations! and you will get the price of Rs. $bet->win_price soon. You betted Rs. $bet->price";

							}

							$winner=new Winner();
							$winner->username=$user->username;
							$winner->match_date=$match->start_date;
							$winner->team1=$match->team1;
							$winner->team2=$match->team2;
							$winner->team=$bet->team;
							$winner->price=$bet->price;
							$winner->win_price=$bet->win_price;
							$winner->save();

						}
						
						else
						{
							foreach($bet->users as $user)
							{
					 			$message="hello $user->username, your bet on $match->team1 vs $match->team2 is completed, and your team $bet->team has lost the game. Better luck next time! Thank You!";
							}
						}
					}	
				}
 		   	}

 		   	else
 		   	{
 		   		echo json_encode(false);die;
 		   	}	 
 		}
	}
}