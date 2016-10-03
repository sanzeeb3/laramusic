@extends('layout.main')

@section('content')       

<div class="container">
    <div class="row">
        <div class="col-sm-5">
                <h2>Reset Password</h2>
                <form method="POST" id="reset" role="form" action="{{url('/auth/change')}}">
                    {!! csrf_field() !!}
                    <input class="form-control" type="password" id="password" name="password"  placeholder="New Password" /><br>
                    <input class="form-control" type="password" name="cpassword"  placeholder="Confirm Password" /><br>
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <button type="submit" class="btn btn-default">Change password</button>
              </form>
        </div>
    </div>
</div>
<script>

$("#reset").validate({
    rules: 
        {
            password: {required:true,
                        minlength : 5
                    },
            cpassword:{
                   minlength : 5,
                   equalTo : "#password"
            }
        },
        
});

</script>
@endsection