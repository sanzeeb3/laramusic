<?php

namespace App\Http\Controllers;
use App\User;
use App\Question;
use App\QuestionUser;
use App\Answer;
use App\Comment;
use App\Vote;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class MusicController extends Controller
{
    public function index()
	{
		$users=User::all();
		$questions=Question::with(['users','answers'=>function($query)
			{
				$query->orderBy('id','desc')
					  ->with(['votes','comments'=>function($query)
					  {
					  		$query->with('votes');
					  }]);
			
			}])->orderBy('id','desc')->get(); 

		$view=View('music.index')->with(['questions'=>$questions,'users'=>$users]);	
		if(Auth::check())
		{
	    	$votesonanswer=Vote::where(['votable_type'=>'App\Answer'])->where(['user_id'=>Auth::user()->id])->get()->toArray();
	    	foreach($votesonanswer as $voteonanswer)
	    	{
	    		$votable[]=$voteonanswer['votable_id'];
	    	}
	       
	        $view->with(['votable'=>$votable]);	
	    }	

		return $view;		
	}

	public function profile()
	{
		if(Auth::check())
		{
			$answersonwhichuservoted = Answer::whereHas('votes', function($query) {
   							 $query->where('user_id', Auth::user()->id);
						})->get();

			$commentsonwhichuservoted = Comment::whereHas('votes', function($query) {
    				$query->where('user_id', Auth::user()->id);
			})->get();

			$user=User::where(['id'=>Auth::user()->id])->with('questions','answers','comments','comments.votes','votes')->first();
			
			return View('music.profile')->with(['user'=>$user,'answers'=>$answersonwhichuservoted,'comments'=>$commentsonwhichuservoted]);	
		}
		else
		{
			echo "profile page will only be displayed if logged in!";
		}
	}

	public function upvoteanswer(Request $request)
	{
		if($request->Ajax())
		{
			if(Auth::check())
			{	
				$upvote = new vote();
				$upvote->votable_id=$request->id;
				$upvote->votable_type='App\Answer';
				$upvote->vote=4;
				$upvote->user_id=Auth::user()->id;
				if($upvote->save())
				{
					echo json_encode(TRUE);die;
				}
			}
			else
			{
				echo json_encode('notloggedin');die;
			}
		}
	}

	public function downvoteanswer(Request $request)
	{
		if($request->Ajax())
		{
			if(Auth::check())
			{	
				$downvote = new vote();
				$downvote->votable_id=$request->id;;
				$downvote->votable_type='App\Answer';
				$downvote->vote=-5;
				$downvote->user_id=Auth::user()->id;
				if($downvote->save())
				{
					echo json_encode(TRUE);die;
				}
			}
			else
			{
				echo json_encode('notloggedin');die;
			}
		}
	}

	public function upvotecomment(Request $request)
	{
		if($request->Ajax())
		{
			if(Auth::check())
			{	
				$upvote = new vote();
				$upvote->votable_id=$request->id;
				$upvote->votable_type='App\Comment';
				$upvote->vote=4;
				$upvote->user_id=Auth::user()->id;
				if($upvote->save())
				{
					echo json_encode(TRUE);die;
				}
			}
			else
			{
				echo json_encode('notloggedin');die;
			}
		}
	}

	public function downvotecomment(Request $request)
	{
		if($request->Ajax())
		{
			if(Auth::check())
			{
				$id=$request->id;
				$downvote = new vote();
				$downvote->votable_id=$id;
				$downvote->votable_type='App\Comment';
				$downvote->vote=-5;
				$downvote->user_id=134;
				if($downvote->save())
				{
					echo json_encode(TRUE);die;
				}
			}
			else
			{
				echo json_encode('notloggedin');die;	
			}
		}
	}

	public function addanswer(Request $request)
	{
		if($request->Ajax())
		{	
			if(Auth::check())
			{
				$answer = new Answer();
				$answer->user_id=Auth::user()->id;
				$answer->answer=$request->answer;
				$answer->q_id=$request->q_id;
				if($answer->save())
				{
					echo json_encode(TRUE);die;
				}
			}
			else
			{
				echo json_encode('notloggedin');die;	
			}
		}
	}

	public function addcomment(Request $request)
	{
		if($request->Ajax())
		{
			if(Auth::check())
			{
			
				$comment = new Comment();
				$comment->user_id=Auth::user()->id;
				$comment->comment_body=$request->comment;
				$comment->answer_id=$request->answer_id;
				if($comment->save())
				{
					echo json_encode(TRUE);die;
				}
			}
			else
			{
				echo json_encode('notloggedin');die;	
			}
		}		
	}

	public function addquestion(Request $request)
	{
		if($request->Ajax())
		{
			if (Auth::check())
			{
				$question = new Question();
				$question->question=$request->question;
				$question->save();

				$addq_id=new QuestionUser();
				$addq_id->q_id=$question->id;
				$addq_id->user_id = Auth::user()->id;
				$addq_id->save();

				echo json_encode(array('status'=>TRUE,'question'=>$request->question));die;
			}
			else
			{
				echo json_encode('notloggedin');die;	
			}
		}		
	}

	public function deletequestion(Request $request)
	{
		if($request->Ajax())
		{
			if (Auth::check())
			{
			
				$question=Question::where(['id'=>$request->id])->first();
				$answers=$question->answers()->get();
				foreach($answers as $answer)
				{
					$comments=$answer->comments()->get();
					foreach($comments as $comment)
					{
						$votes=$comment->votes()->get();
						foreach($votes as $vote)
						{
							$vote->delete();
						}
						$comment->delete();
					}

					$votes=$answer->votes()->get();
					foreach($votes as $vote)
					{
						$vote->delete();
					}
					$answer->delete();
				}
				$question->delete();
				
				echo json_encode(TRUE);
			}
			else
			{
				echo json_encode('notloggedin');die;	
			}
		}		
	}

	public function deleteanswer(Request $request)
	{
		
			if (Auth::check())
			{
			
				$answer=Answer::where(['id'=>$request->id])->first();
				$comments=$answer->comments()->get();
					
				foreach($comments as $comment)
				{
					$votes=$comment->votes()->get();
					foreach($votes as $vote)
					{
						$vote->delete();
					}
					$comment->delete();
				}

				$votes=$answer->votes()->get();
				foreach($votes as $vote)
				{
					$vote->delete();
				}
				$answer->delete();
				
				echo json_encode(TRUE);
			}
			else
			{
				echo json_encode('notloggedin');die;	
			}
				
	}

	public function deletecomment(Request $request)
	{
		if($request->Ajax())
		{
			if (Auth::check())
			{
				$comment=Comment::where(['id'=>$request->id])->first();		
				$votes=$comment->votes()->get();
				foreach($votes as $vote)
				{
					$vote->delete();
				}
				$comment->delete();
			
				echo json_encode(TRUE);
			}
			else
			{
				echo json_encode('notloggedin');die;	
			}
		}
				
	}

	public function cancelvoteofcomment(Request $request)
	{
		if($request->Ajax())
		{
			if (Auth::check())
			{
				Vote::where(['votable_id'=>$request->id])->where(['votable_type'=>'App\Comment'])->delete();
				echo json_encode(TRUE);
			}
			else
			{
				echo json_encode('notloggedin');die;	
			}
		}		
	}


	public function cancelvoteofanswer(Request $request)
	{
		if($request->Ajax())
		{
			if (Auth::check())
			{
				Vote::where(['votable_id'=>$request->id])->where(['votable_type'=>'App\Answer'])->delete();
				echo json_encode(TRUE);
			}
			else
			{
				echo json_encode('notloggedin');die;	
			}
		}		
	}
}

