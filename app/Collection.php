<?php

namespace App;

use \App\Models;

class Collection extends Model
{
    protected $fillable = ['user_id','post_id'];

    public function user()
    {
        return $this->belongsTo('\App\User','user_id','id');
    }

    public function post()
    {
        return $this->belongsTo('App\Post','post_id','id');
    }
}
