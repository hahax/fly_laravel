<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aether extends Model
{
    const AETH_LOCAL = 0;
    const AETH_FILE = 1;
    const AETH_VIDEO = 2;

    protected $fillable = ['path','ip','user_id','size','name','type','video_cate'];

    protected $hidden = ['updated_at','ip','user_id','file_type'];

    public function cate()
    {
        return $this->hasOne('App\Cate');
    }
}
