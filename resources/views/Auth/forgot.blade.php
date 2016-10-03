@extends('layout.main')

@section('content')       

<div class="container">
    <div class="row">
        <div class="col-sm-5">
                <h2>Reset Email</h2>
                <form method="POST" id="reset" role="form" action="{{url('auth/token')}}">
                    {!! csrf_field() !!}
                    <input class="form-control" type="email" name="email"  placeholder="Email Address" /><br>
                    <button type="submit" class="btn btn-default">Send Reset link</button>
              </form>
        </div>
    </div>
</div>
<script>

$("#reset").validate({
    rules: 
        {
            email: {required:true},
        },
        
});

</script>
@endsection