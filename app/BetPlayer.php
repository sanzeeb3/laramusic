<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class BetPlayer extends model 
{

    public $timestamps = true;
    protected $fillable = ['player','match_id'];
    protected $table = 'betplayers';

  	public function match()
    {
        return $this->belongsTo('App\Match','match_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User','betplayer_user','betplayer_id','user_id'); //The third argument is the foreign key name of the model on which you are defining the relationship, while the fourth argument is the foreign key name of the model that you are joining to:
    }
}