<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Socialite;


class AuthController extends Controller
{
    public function loginform()
	{
		return View('auth.login');
	}
	
	public function redirectToProvider()
	{
    	 return Socialite::driver('facebook')->redirect();
	}

	public function handleProviderCallback()
	{
    	 $user = Socialite::driver('facebook')->user();
    	 dd($user);	
	}

	public function googleLogin()
	{
		return Socialite::driver('google')->redirect();
	}

	public function googleCallback()
	{
		$user= Socialite::driver('google')->user();
		dd($user);
	}

	

	public function register(Request $request)
	{
		$password=Hash::make($request->get('password'));
		$name=$request->get('name');
    	$email=$request->get('email');
    	$token = str_shuffle('abcdefgh1234567890xsY');
		$insert= User::insert(['username'=>$name,'password'=>$password,'email'=>$email,'status'=>0,'remember_token'=>$token]);
		
		return '/auth/verify/'.$name.'/'.$token;

	}

	public function verify($username, $token)
	{ 			
		$getModel=User::where(['username'=>$username])->first();			
		if($getModel->remember_token==$token)
		{
			$getModel->status=1;
			$getModel->update();
			return redirect('/auth/login')->with('message','Email verified!!');	
		}
		else
		{
			return redirect('/auth/login')->with('message','Email verification failed. Token mismatch!');	
		}
	}

	public function authenticate(Request $request)
    {
    	$password=$request->password;
        $email=$request->email;

        if (Auth::attempt(['email' => $email, 'password' => $password,'status'=>1]) )
        {     
   	    	return redirect()->intended('/bet')->with('message','Logged in!');;   
        }
        else 
        {
            abort(403, 'Unauthorized action.');
        }
   		
    }

    public function forgot()
	{
		return View('auth.forgot');
	}

	public function token(Request $request)
	{
		$token = str_shuffle('abcdefgh1234567890xsY');
		$getEmail=$request->get('email');
		$getModel=User::where(['email'=>$getEmail])->first();
			
		if($getModel)
		{
			$getModel->remember_token=$token;
			$getModel->update();

			return '/auth/reset/'.$getModel->username.'/'.$token;
		}
		else
		{
            return redirect('/login')->with('message','Email doesnot exist!');
		}
		
	}

    public function reset($username, $token)
	{ 			
		$getModel=User::where(['username'=>$username])->first();			
		if($getModel->remember_token==$token)
		{
				return View('auth.change', ['id' =>$getModel->id]);	
		}
		else
		{
			return redirect('/auth/forgot');	
		}
	}

	public function change(Request $request)
	{ 
		$getid=$request->get('id');
		$getModel=User::where(['id'=>$getid])->first();
		$password=Hash::make($request->get('password'));
		$getModel->password=$password;
		$getModel->update();
		return redirect('/auth/login')	
                ->with('message','Password changed!');
	}

	public function checkemail(Request $request)
	{
		if($request->ajax())
		{
			$check=User::where(['email'=>$_POST['email']])->first();
			if(!$check)
			{
				echo json_encode(TRUE);die;
			}

			echo json_encode(FALSE);die;
		}	
	}

	public function logout() 
	{
   	 	Auth::logout();   
    	return redirect('/bet')			
                ->with('message','Logged out!');
    }
}