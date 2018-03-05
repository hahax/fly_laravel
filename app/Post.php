<?php

namespace App;

use \App\Model;

class Post extends Model
{
    protected $fillable = ['title','content','user_id','menus'];

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment')->orderBy('created_at','asc');
    }

    public function collection()
    {
        return $this->hasMany('App\Collection')->orderBy('created_at','desc');
    }

    public function cate()
    {
        return $this->belongsTo('App\Cate','menus');
    }
}
