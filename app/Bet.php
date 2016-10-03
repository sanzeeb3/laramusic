<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Bet extends model 
{

    public $timestamps = true;
    protected $fillable = ['team','price','user_id','match_id','created_at'];

  	public function match()
    {
        return $this->belongsTo('App\Match','match_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Match','user_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User','bet_user','bet_id','user_id'); //The third argument is the foreign key name of the model on which you are defining the relationship, while the fourth argument is the foreign key name of the model that you are joining to:
    }
}