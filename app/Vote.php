<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Vote extends model 
{

    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'votes';
    protected $fillable = ['user_id','vote','votable_id','votable_type'];

    public function votable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id'); 
    }
}
