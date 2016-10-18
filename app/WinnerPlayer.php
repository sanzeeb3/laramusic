<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class WinnerPlayer extends model 
{

    public $timestamps = false;
    protected $table = 'winners_layers';
    protected $fillable = ['match_id','player','username'];

}