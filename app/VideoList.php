<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoList extends Model
{
    protected $fillable = ['name','path','ip','user_id','file_type'];

    protected $hidden = ['updated_at','ip','user_id','file_type'];
}
