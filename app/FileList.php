<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileList extends Model
{
    protected $fillable = ['disk','path','url','ip','user_id','file_type','file_name'];
}
