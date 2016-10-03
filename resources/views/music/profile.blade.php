@extends('layout.main')
@section('content')  
<h2>Hello <?php echo Auth::user()->username;?></h2>
<h4>My questions:</h4>
<?php foreach($user->questions as $question)
{
	echo "<li> $question->question";
	?> <a href="" class="deletequestion" data-id="<?php echo $question->id;?>">Delete</a><?php
    ?> <a href="" class="editquestion" data-id="<?php echo $question->id;?>">Edit</a><?php

}
?>
<h4>My answers:</h4>
<?php foreach($user->answers as $answer)
{
	echo "<li> $answer->answer";
	?> <a href="" class="deleteanswer" data-id="<?php echo $answer->id;?>">Delete</a><?php	
}
?>
<h4>My Comments:</h4>
<?php foreach($user->comments as $comment)
{
	echo "<li> $comment->comment_body";	
	?> <a href="" class="deletecomment" data-id="<?php echo $comment->id;?>">Delete</a><?php
}
?>
<h4>Answers on which i voted:</h4>
<?php foreach($answers as $answer)
{
	echo "<li> $answer->answer";	
	?> <a href="" class="cancelvoteofanswer" data-id="<?php echo $answer->id;?>">Cancel Vote</a><?php
}
?>
<h4>Comments on which i voted:</h4>
<?php foreach($comments as $comment)
{
    echo "<li> $comment->comment_body";    
    ?> <a href="" class="cancelvoteofcomment" data-id="<?php echo $comment->id;?>">Cancel Vote</a><?php
}
?>

<script>
$(document).on('click','.deletequestion',function(e)
{
	e.preventDefault();
	var id=$(this).data('id');
	$.ajax({

	    type:"POST",
        url: "{{url('/music/deletequestion')}}",
        data: {
        "_token": "{{ csrf_token() }}",
        "id":id
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

$(document).on('click','.deleteanswer',function(e)
{
    e.preventDefault();
    var id=$(this).data('id');
    $.ajax({

        type:"POST",
        url: "{{url('/music/deleteanswer')}}",
        data: {
        "_token": "{{ csrf_token() }}",
        "id":id
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

$(document).on('click','.deletecomment',function(e)
{
    e.preventDefault();
    var id=$(this).data('id');
    $.ajax({

        type:"POST",
        url: "{{url('/music/deletecomment')}}",
        data: {
        "_token": "{{ csrf_token() }}",
        "id":id
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

$(document).on('click','.cancelvoteofanswer',function(e)
{
    e.preventDefault();
    var id=$(this).data('id');
    $.ajax({

        type:"POST",
        url: "{{url('/music/cancelvoteofanswer')}}",
        data: {
        "_token": "{{ csrf_token() }}",
        "id":id
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

$(document).on('click','.cancelvoteofcomment',function(e)
{
    e.preventDefault();
    var id=$(this).data('id');
    $.ajax({

        type:"POST",
        url: "{{url('/music/cancelvoteofcomment')}}",
        data: {
        "_token": "{{ csrf_token() }}",
        "id":id
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