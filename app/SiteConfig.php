<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteConfig extends Model
{
    protected $fillable = [
        'site_name','seo','seo_key','user_reg','forum_sh',
        'email_sh','site_copyright','site_icp','site_tongji',
        'smtp_host','smtp_port','smtp_name','smtp_password','uedit',
    ];
}
