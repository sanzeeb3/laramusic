<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Player extends model 
{

    public $timestamps = false;
    protected $fillable = ['team','player_name'];

}