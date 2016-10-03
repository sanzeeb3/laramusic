<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Result extends model 
{

    public $timestamps = false;
    protected $table = 'results';
    protected $fillable = ['won_by','match_id'];

    public function match()
    {
        return $this->belongsTo('App\Match','match_id');
    }

}