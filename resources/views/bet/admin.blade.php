@extends('layout.main')
@section('content')    
<div class="container">
	<div class="row">
		<div class="col-sm-5">
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
            <br><br>
            <label>Add players:</label>
            <form id="add-players" action="{{url('/bet/add-players')}}" method="POST" class="form-inline">
            {!! csrf_field() !!}
            Team: <input type="text" class="form-control" name="team" placeholder="Team"><br><br>
            Player Name: <input type="text" class="form-control" name="player_name[]" placeholder="Palyer Name"> 
               <div id="dynamicInput">
                    <span class="glyphicon glyphicon-plus" onClick="addInput('dynamicInput');"></span>
                </div>
            <input type="submit" class="form-control" value="Add Player">
            </form>

            <br><br>
            <label>Add Matches</label>
            <form id="add" action="{{url('/bet/add-match')}}" method="POST" class="form-inline">
            {!!csrf_field()!!}
            <input class="form-control" type="text" name="team1" placeholder="Team 1">
            <input type="text" class="form-control" name="team1_value" placeholder="Team 1 Value"><br><br>
            <input type="text" class="form-control" name="team2" placeholder="Team 2">
            <input type="text" class="form-control" name="team2_value" placeholder="Team 2 Value"><br><br>
            <input type="date" class="form-control" name="start_date">
            <input type="submit" class="form-control" value="Add">
            </form>


		 	<h1>All Matches</h1>
		 	<?php foreach($matchesbydate as $startDate=>$matches)
		 	{
                echo "<h2 style ='background-color:silver; display:inline' >$startDate</h2>";
                foreach($matches as $match)
                {

		 		    echo "<h2><li>$match->team1 ($match->team1_value) Vs $match->team2 ($match->team2_value)</h2> ";
                    if($match->start_date<$now)
                    {
                        if($match->result)
                        {
                            echo "Won by ";
                            echo $match->result->won_by;
                            echo " <u>Winner Awarded</u>"; 
                        }
                        else
                        {
                            echo "Won by:";
                        
                             ?>
                            <form class="form-inline result"  method="POST" action="{{url('/bet/result')}}">
                            <select class="form-control" name="team">
                                <option value="1"><?php echo $match->team1;?></option>
                                <option value="2"><?php echo $match->team2;?></option>
                            </select>
                            <input type="hidden" name="id" value="<?php echo $match->id;?>">
                            <input class="form-control" type="submit" value="Award winner">
                            <br>                    
                            <?php
                        }
                    }
		 		    ?><br><form class="form-inline update" method="POST" action="{{url('/bet/update-value')}}">
		 		    {!! csrf_field() !!}
		 		
		 		    <label>EDIT:</label><br>
				    <input type="text" class="form-control" name="team1" value="<?php echo $match->team1;?>"> 
                    <input class="form-control" type="text" name="team1_value" value="<?php echo $match->team1_value;?>"><br><br>
		 	        <input type="text" class="form-control" name="team2" value="<?php echo $match->team2;?>">     
                    <input class="form-control" type="text" name="team2_value" value="<?php echo $match->team2_value;?>"><br><br>
	 	            <input type="date" class="form-control" name="start_date" value="<?php echo $match->start_date;?>"> 
                    <input type="hidden" name="id" value="<?php echo $match->id;?>">	
		 	        <input class="form-control" type="submit" value="update">
		 		
		 		    </form>
		 		    </li>
		 		    <br><br>
		 		    <?php
		 	    }
            }
		 	?>
		</div>
        <div class="col-sm-7">
        <h3>All time Winners List:</h3>
            <table id="winner" class="table table-hover">    
                <thead><tr><td>S.N.</td><td>Username</td><td>Match</td><td>Winner</td><td>Match Date</td><td>Bet Price</td><td>Won Price</td></tr></th></thead>
                <tbody>
                <?php $i=1;?>
                <?php foreach($winners as $winner):?>
                    <tr><td><?php echo $i++;?></td><td><?php echo $winner->username;?></td><td><?php echo "$winner->team1 vs $winner->team2";?></td><td><?php echo $winner->team;?></td><td><?php echo $winner->match_date;?></td><td><?php echo $winner->price;?></td><td><?php echo $winner->win_price;?></td></tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <br>
        <B>All Players:</B>
            @foreach($playersbyteam as $team=>$players)
            <h5>{{$team}}</h5>
                @foreach($players as $player)
                    <li>{{$player->player_name}}</li>
                @endforeach
            @endforeach    
        </div> 
	</div>
</div>

<script>

function addInput(divName)
{ 
    var newdiv = document.createElement('div');
    newdiv.innerHTML = "<input type='text' class='form-control' name='player_name[]' placeholder='Player Name'><br>";
    document.getElementById(divName).appendChild(newdiv);    
}

$('#winner').DataTable();

    $("#add").validate({

        rules: {
            team1_value: {
                     required:true,
                     number:true,
                   },
            team2_value: {
                    required:true,
                    number:true,
                   },
        }, 
    });

    $(document).on('submit', '.update', function (e) 
    {
        e.preventDefault();
        var frm = $(this);
     	
 			$.ajax({
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
           	         		location.reload();
           	         	}
           	        }
             });
 			     
    });  


    $(document).on('submit', '#add', function (e) 
    {
        e.preventDefault();
        var frm = $(this);
        
            $.ajax({
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
                            alert('Match Added!');
                            location.reload();
                        }

                        if(data == 'dateexpired')
                        {
                            alert('Select a valid date!');
                        }

                    }
             });
                 
    });  

    $(document).on('submit', '#add-players', function (e) 
    {
        e.preventDefault();
        var frm = $(this);
        
            $.ajax({
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
                            alert('Player Added!');
                            location.reload();
                        }
                    }
             });
                 
    });  
    $(document).on('submit', '.result', function (e) 
    {
        e.preventDefault();
        var frm = $(this);
        
            $.ajax({
                type: frm.attr('method'),
                url: frm.attr('action'),
                data: frm.serialize(),
                dataType: 'json',
                success: function (data)
                    {
                        console.log(data);
                        if(data == 'notloggedin')
                        {
                            alert('You must login first!');
                        }

                        else if(data==true)
                        {                
                                alert('awarded!');
                                location.reload();
                        }
                    }
             });
                 
    });  
</script>
@endsection