@extends('layout.main')
@section('content')    
<div class="container">
	<div class="row">
		<div class="col-sm-6">
		<br>
			<?php
    		if(Auth::check())
    		{
        		echo "You are logged in as "; 
        		echo "<mark>";
        		echo Auth::user()->username;
        		echo "</mark>";
      			?> <a href="{{url('/auth/logout')}}"><button class="btn"> logout</button></a><?php
        	}
        	?>       	

		 	<h1>Upcoming Matches</h1>
		 	<?php foreach($matchesbydate as $startDate => $matches)
		 	{
                echo "<p style ='color:red; display:inline; border:solid red 2 px' > Date: $startDate</p>";
                foreach($matches as $match)
                {
		 		    echo "<h2><li>$match->team1 ($match->team1_value) Vs $match->team2 ($match->team2_value)</h2></li> ";
                    ?><br><form class="form-inline bet" method="POST" action="{{url('/bet/process-team')}}">
		 		    {!! csrf_field() !!}
		 		   
		 		    Rs.<input class="form-control" type="text" id="price" name="price">On 
		 	 	    <select class="form-control" name="team">
		     	        <option value="1"><?php echo $match->team1;?></option>
		 	            <option value="2"><?php echo $match->team2;?></option>
		 	        </select>
		 	        <input type="hidden" name="id" value="<?php echo $match->id;?>">
		 	        <input type="hidden" name="team1_value" value="<?php echo $match->team1_value;?>">
		 	        <input type="hidden" name="team2_value" value="<?php echo $match->team2_value;?>">
		 	        <input class="form-control" type="submit" value="submit">
		 		   </form><br>
		 	            <label>Highest Scorer</label>
                        <form class="form-inline highest-scorer" method="POST" action="{{url('/bet/highest-scorer')}}">
                        {!! csrf_field() !!}
                        <select class="form-control" name="highest_scorer">
                            @foreach($playersbyteam->whereIn('team',[$match->team1,$match->team2]) as $player)
                            <option><?php echo $player->player_name;?></option>
                            @endforeach
                        <input class="form-control" type="submit" value="submit">
                        </form><br>
                        </select>

		 		   <br><br>
		 		   <?php
		 	    }
            }
		 	?>
		</div>

    	<div class="col-sm-6">
        <h3>All time Winners List:</h3>
            <table id="winner" class="table table-hover">    
                <thead><tr><td>S.N.</td><td>Username</td><td>Match</td><td>Winner</td><td>Match Date</td><td>Bet Price</td><td>Won Price</td></tr></th></thead>
                <tbody>
                <?php $i=1;?>
                <?php foreach($winners as $winner):?>
                    <tr><td><?php echo $i++;?></td><td><?php echo $winner->username;?></td><td><?php echo "$winner->team1 vs $winner->team2";?></td><td><?php echo $winner->team;?></td><td><?php echo $winner->match_date;?></td><td><?php echo $winner->price;?></td><td><?php echo $winner->win_price;?></td></tr>
                <?php endforeach;?>
                </tbody>
            </table><br><br>	
            <B>Players to watch for:</B>
            @foreach($playersbyteam->groupBy('team') as $team=>$players)
            <h5>{{$team}}</h5>
                @foreach($players as $player)
                    <li>{{$player->player_name}}</li>
                @endforeach
            @endforeach    
		</div>
	</div>
</div>

<script>
$('#winner').DataTable();


    $(".bet").validate({

        rules: {
            '#price': {
                     required:true,
                     number:true,
                   },
        }, 
    });

    $(document).on('submit', '.bet', function (e) 
    {
        e.preventDefault();
        var frm = $(this);
     	swal({
  			title: "Are you sure?",
  			text: "You will not be able to cancel the bet!",
  			type: "warning",
  			showCancelButton: true,
  			confirmButtonClass: "btn-danger",
  			confirmButtonText: "Yes, confirm bet!",
  			closeOnConfirm: false
		},
			function(){
 			var jqXHR=$.ajax({
            		type: frm.attr('method'),
            		url: frm.attr('action'),
           		 	data: frm.serialize(),
            		dataType: 'json',
            		success: function (data)
            	    	{
             
           	         		if(data == 'notloggedin')
           	         		{
           	         			alert('You must login first!');
           	         		}

           	         		else if(data==true)
           	         		{
           	         			swal('Bet Success! The details has been sent to your email!');
           	         		}

                            else if(data=='dateexpired')
                            {
                                swal('The match bet time expired!');
                            }
           	        	}
             	});
 				
            jqXHR.fail(function( jqXHR, textStatus, errorThrown ) {
                if(jqXHR.status == 401) 
               {
                     alert('You must login first');
               }         
            });
      	});       
    });  

    $(document).on('submit', '.highest-scorer', function (e) 
    {
        e.preventDefault();
        var frm = $(this);
        swal({
            title: "Are you sure?",
            text: "You will not be able to cancel the bet!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, confirm bet!",
            closeOnConfirm: false
        },
            function(){
            $.ajax({
                    type: frm.attr('method'),
                    url: frm.attr('action'),
                    data: frm.serialize(),
                    dataType: 'json',
                    success: function (data)
                        {

                            if(data=='UnderConstruction')
                            {
                                sweetAlert("Oops...", "Players Bet Under Construction! Bet not registered", "error");
                            }
                        }
            });
        });       
    });  
</script>
@endsection