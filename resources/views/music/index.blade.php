@extends('layout.main')
@section('content')    
<center>thetoptens</center>


    @if ( session()->has('message') )
        <div class="alert alert-success alert-dismissable">{{ session()->get('message') }}</div>
    @endif
<br>
<?php
    if(Auth::check())
    {
        echo "You are logged in as "; 
        echo Auth::user()->username;
        ?> <a href="{{url('/music/profile')}}">View my profile</a> <a href="{{url('/auth/logout')}}">logout</a><?php

        echo "<table border='2'><thead><tr><td>Username</td><td>Email</td></tr></thead>";
        echo "<tbody>";
        foreach($users as $user)
        {
            echo "<tr><td>$user->username</td><td>$user->email</td></tr>"; 
        }
        echo "</tbody></table>";


    }
?>



<textarea>Ask a question...</textarea><button class="addquestion">POST</button>
<?php		
	$i=1;
	foreach($questions as $question)
	{
        echo "<h1>"; echo $i++; echo "."; echo"<div id='question'>";  print_r($question->question);
        echo "<sub><i>"; 
        foreach($question->users as $user)
        {
            echo $user->username;
        }
        echo "</i></sub>";
        echo "</div>";
        echo "</h1>";

        $answers=$question->answers->sortByDesc('votes.voteSum');
 
        foreach($answers as $answer)
		{
            echo "<br><h2>"; print_r($answer->answer);
            if(isset($answer->votes->voteSum))
            {
                echo"<br><h2>";echo"<pre>";
                if(isset($answer->votes->voteSum))
                {
                    print_r($answer->votes->voteSum);
                }
            }
            
            if(isset($votable))
            {
                if(in_array($answer->id, $votable))
                {
                    echo "Upvoted!";
                }
                else
                {
                    ?><a href="" class="upvoteanswer" data-id="<?php echo $answer->id;?>"> Upvote</a> <a href="" class="downvoteanswer" data-id="<?php echo $answer->id;?>"> Downvote</a><?php
                }
            }
            else
            {
                ?><a href="" class="upvoteanswer" data-id="<?php echo $answer->id;?>"> Upvote</a> <a href="" class="downvoteanswer" data-id="<?php echo $answer->id;?>"> Downvote</a><?php
            }
			echo "</h3>";
            $comments=$answer->comments->sortByDesc('votes.voteSum');
			foreach($comments as $comment)
			{
		        echo"<br>";	print_r($comment->comment_body);
                if(isset($comment->votes->voteSum))
                {
			         echo"<br>";print_r($comment->votes->voteSum);
                }
                ?><a href="" class="upvotecomment" data-id="<?php echo $comment->id;?>"> Upvote</a> <a href="" class="downvotecomment" data-id="<?php echo $comment->id;?>"> Downvote</a><?php
				echo "<br>";
			}
			?><textarea>Comment here...</textarea><button data-id="<?php echo $answer->id;?>" class="addcomment">Go</button><?php
		}				
		?><br><textarea>Answer here...</textarea><button data-id="<?php echo $question->id;?>" class="addanswer">Go</button><?php                                                                                                                           
	}  
?>
<center>copyrights @ thetoptens</center>

<script>


$(document).on('click','.addquestion',function(e)
{
    e.preventDefault();
    var question = $(this).prev().val();

    $.ajax({
        type:"POST",
        url: "{{url('/music/addquestion')}}",
        data: {
        "_token": "{{ csrf_token() }}",
        "question": question
        },

        success: function (data) {
            var res = $.parseJSON(data);
            if(res.status == true)
            {
                window.location.reload();
            }
            else if(res == 'notloggedin')
            {
                alert('You must login first!');

            }
        }
    });
});

$(document).on('click','.addcomment',function(e)
{
    e.preventDefault();
    var comment = $(this).prev().val();
    var answer_id=$(this).data('id');
   
    $.ajax({
        type:"POST",
        url: "{{url('/music/addcomment')}}",
        data: {
        "_token": "{{ csrf_token() }}",
        "comment": comment,
        "answer_id":answer_id
        },

        success: function (data) {
            var res = $.parseJSON(data);
            if(res == true)
            {
                window.location.reload();
            }
            else if(res == 'notloggedin')
            {
                alert('You must login first!');

            }
        }
    });
});

$(document).on('click','.addanswer',function(e)
{
    e.preventDefault();
    var answer = $(this).prev().val();
    var q_id=$(this).data('id');
    $.ajax({
        type:"POST",
        url: "{{url('/music/addanswer')}}",
        data: {
        "_token": "{{ csrf_token() }}",
        "answer": answer,
        "q_id":q_id
        },

        success: function (data) {
            var res = $.parseJSON(data);
            if(res == true)
            {
                window.location.reload(); 
            }
            else if(res == 'notloggedin')
            {
                alert('You must login first!');
            }
        }
    });
});

$(document).on('click','.upvoteanswer',function(e)
{
	e.preventDefault();
	var id=$(this).data('id');
	$.ajax({
		type:"POST",
        url: "{{url('/music/upvoteanswer')}}",
        data: {
        "_token": "{{ csrf_token() }}",
        "id": id
        },
        success: function (data) {
        	var res = $.parseJSON(data);
            if(res == true)
            {
                   window.location.reload();

            }
            else if(res == 'notloggedin')
            {
                alert('You must login first!');

            }
        }
    });
});


$(document).on('click','.downvoteanswer',function(e)
{
	e.preventDefault();
	var id=$(this).data('id');

	$.ajax({
		type:"POST",
        url: "{{url('/music/downvoteanswer')}}",
        data: {
        "_token": "{{ csrf_token() }}",
        "id": id
        },
        success: function (data) {
        	var res = $.parseJSON(data);
            if(res == true)
            {
                window.location.reload();			
            }
            else if(res == 'notloggedin')
            {
               alert('You must login first!');
            }
        }
    });
});

$(document).on('click','.downvotecomment',function(e)
{
	e.preventDefault();
	var id=$(this).data('id');

	$.ajax({
		type:"POST",
        url: "{{url('/music/downvotecomment')}}",
        data: {
        "_token": "{{ csrf_token() }}",
        "id": id
        },
        success: function (data) {
        	var res = $.parseJSON(data);
            if(res == true)
            {
                window.location.reload();
				
            }
            else if(res == 'notloggedin')
            {
               alert('You must login first!');
            }
        }
    });
});

$(document).on('click','.upvotecomment',function(e)
{
	e.preventDefault();
	var id=$(this).data('id');

	$.ajax({
		type:"POST",
        url: "{{url('/music/upvotecomment')}}",
        data: {
        "_token": "{{ csrf_token() }}",
        "id": id
        },
        success: function (data) {
        	var res = $.parseJSON(data);
            if(res == true)
            {
		        window.location.reload();	
            }
            else if(res == 'notloggedin')
            {
               alert('You must login first!');
            }
        }
    });
});
</script>
@endsection