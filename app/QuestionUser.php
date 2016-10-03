<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class QuestionUser extends model 
{

    public $timestamps = false;
    protected $table = 'question_user';
    protected $fillable = ['q_id','user_id'];

}