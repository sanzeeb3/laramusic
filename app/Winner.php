<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Winner extends model 
{

    public $timestamps = false;
    protected $table = 'winners';
    protected $fillable = ['team1','team2','team','win_price','price','match_date','username'];

}