<?php

namespace App;

use \App\Model;

class Cases extends Model
{
    protected $table = 'cases';

    protected $fillable = ['title','content','pic_path','git_path','http_path','case_sort'];
}
