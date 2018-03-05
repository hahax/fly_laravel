<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PicList extends Model
{
    const QINIU = "qiniu";

    protected $fillable = ['disk','path','url','ip','user_id','file_type'];

    protected $hidden = ['updated_at','file_type','user_id','ip','use'];
}
