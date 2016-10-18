<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class BetPlayerUser extends model 
{

    public $timestamps = false;
    protected $table = 'betplayer_user';
    protected $fillable = ['betplayer_id','user_id'];

}