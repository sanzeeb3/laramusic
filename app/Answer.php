<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Answer extends model 
{

    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'answers';
    protected $fillable = ['answer','q_id','user_id'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id'); 
    }

    public function question()
    {
        return $this->belongsTo('App\question','q_id','id'); 
    }

    public function comments()
    {
        return $this->hasMany('App\Comment','answer_id','id'); 
    }

    public function votes()
    {
        return $this->morphOne('App\Vote', 'votable')
                    ->selectRaw('SUM(vote) as voteSum, votable_id')
                    ->groupBy('votable_id');
    }
}