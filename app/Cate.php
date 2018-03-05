<?php

namespace App;

use \App\Model;

class Cate extends Model
{
    protected $fillable = ['cate_order','cate_name','cate_key','description'];

    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function post()
    {
        return $this->hasMany('App\Post','menus','id');
    }
}
