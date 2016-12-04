<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Question extends model 
{

    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'questions';
    protected $fillable = ['question'];

    public function users()
    {
        return $this->belongsToMany('App\User','question_user','q_id','user_id')->wherePivot('approved',  1); //The third argument is the foreign key name of the model on which you are defining the relationship, while the fourth argument is the foreign key name of the model that you are joining to:
    }

    public function answers()
    {
        return $this->hasMany('App\Answer','q_id','id'); 
    }
}