@extends('layout.main')

@section('content')       

<div class="container">
    <div class="row">
        <div class="col-sm-5">
            @if ( session()->has('message') )
                <div class="alert alert-success alert-dismissable">{{ session()->get('message') }}</div>
            @endif
            <a href="{{url('auth/login-facebook')}}">Login with facebook</a>
            <h2>Login to your account</h2>
                <form method="POST" id="login" role="form" action="{{url('/auth/authenticate')}}">
                    {!! csrf_field() !!}
                    <input class="form-control" type="email" name="email"  placeholder="Email Address" /><br>
                    <input class="form-control" type="password" name="password"  placeholder="Password" /><br>
                    <input  name="remember" id="remember" type="checkbox" class="checkbox"> 
                    Keep me signed in
                    <button type="submit" class="btn btn-default">Login</button>
              </form>
              <a href="{{url('/auth/forgot')}}">Forgot Password?</a>
        </div>
        <div class="col-sm-4">
            <h1>OR,</h1><br>
            <h2>New User Signup!</h2>
            <form method="POST" id="signup" role="form" action="{{url('/auth/register')}}">
                {!! csrf_field() !!}
                <input type="text" class="form-control" name="name" id="name"  placeholder="Name"><br>
                <input type="email" class="form-control" name="email" id="email" placeholder="Email Address"/><br>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password"><br>
                <button type="submit"  class="btn btn-default">Signup</button>
            </form>
        </div>
    </div>
</div>
<script>

$("#login").validate({
    rules: 
        {
            email: {required:true},
            password:{required:true},
        },
        
});

$("#signup").validate({
    rules: 
        {
            name: {required:true},
            email:{
                    required:true,
                    remote:
                      {
                            url: "{{url('/auth/checkemail')}}",
                            type: "post"
                      }
                  },
            password:{
                      required:true,
                      minlength : 5},
        },
    messages:
        {
            email:
            {
                remote:"Email already in use"
            }
        }   
});


</script>
@endsection