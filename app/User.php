<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    use SoftDeletes;
  
    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $dates = ['deleted_at'];

    public $timestamps = false;

    protected $fillable = ['username',  'password','email','status','role'];

    protected $hidden = ['password', 'remember_token'];

    public function questions()
    {
    	return $this->belongsToMany('App\Question','question_user','user_id','q_id');    //question_user alphabetical order of relation
    }

    public function answers()
    {
    	return $this->hasMany('App\Answer','user_id','id');    
    }

    public function comments()
    {
        return $this->hasMany('App\Comment','user_id','id');    
    }

    public function votes()
    {
        return $this->hasMany('App\Vote','user_id','id');    
    }

    public function bets()
    {
        return $this->belongsToMany('App\Bet','bet_user','user_id','bet_id');
    }
}