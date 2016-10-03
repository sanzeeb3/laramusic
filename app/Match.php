<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Match extends model 
{

    public $timestamps = false;
    protected $table = 'matches';
    protected $fillable = ['team1','team2'];

    public function result()
    {
        return $this->hasOne('App\Result','match_id');
    }

    public function bets()
    {
        return $this->hasMany('App\Bet','match_id');
    }

}