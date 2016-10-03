<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Comment extends model 
{

    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'comments';
    protected $fillable = ['answer_id','user_id','comment_body'];

    public function votes()
    {
        return $this->morphOne('App\Vote', 'votable')
                    ->selectRaw('SUM(vote) as voteSum, votable_id')
                    ->groupBy('votable_id');
    }

    public function answer()
    {
        return $this->belongsTo('App\Answer','answer_id','id'); 
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id'); 
    }

}