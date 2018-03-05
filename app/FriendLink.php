<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FriendLink extends Model
{
    protected $fillable = ['sort','name','link','is_show'];
}
