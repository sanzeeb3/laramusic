<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class BetUser extends model 
{

    public $timestamps = false;
    protected $table = 'bet_user';
    protected $fillable = ['bet_id','user_id'];

}