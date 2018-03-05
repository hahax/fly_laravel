<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    const DEFAVA = '/uploads/avatars/default.jpeg';

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     * 转换成数组或 JSON 时隐藏属性
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(\App\Post::class,'user_id','id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment')->orderBy('created_at','desc');
    }

    public function collection()
    {
        return $this->hasMany('App\Collection')->orderBy('created_at','desc');
    }

    public static function isSuperAdmin($post=null)
    {
        if($post)   //查看文章是否是管理员创建，$post:user_id
        {
            $user = User::find($post);
            if($user->id == 1 && $user->isadmin == 1)
            {
                return true;
            }else
            {
                return false;
            }
        }else
        {
            if(Auth::check())   //查看登录用户是否是管理员
            {
                $user = Auth::user();
                if($user->id == 1 && $user->isadmin == 1)
                {
                    return true;
                }else
                {
                    return false;
                }
            }
        }
    }
}
