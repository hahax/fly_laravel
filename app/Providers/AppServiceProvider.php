<?php

namespace App\Providers;

use App\Cate;
use App\SiteConfig;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \view()->composer(['layouts.header','user.setting','user.avatar','user.pass','user.index','user.indexColl','user/message','layouts.menus','layouts.umenu'], function ($view) {
            $user = \Auth::user();
            $view->with('user',$user);
        });
        
        \view()->composer('layouts.*', function ($view) {
            $path = \Request::segment(2);
            $view->with('path',$path);
        });

        \view()->composer('layouts.menus', function ($view) {
            $path = \Request::segment(3);
            $view->with('path',$path);
        });

        \view()->composer('layouts.hotpost',function($view){
            $hots = \App\Post::withCount('comments')->orderBy('comments_count','desc')->take(10)->get();    //本周热议
            $comms = \App\User::withCount("comments")->orderBy("comments_count","desc")->take(12)->get();    //回帖周榜
//            $comms = \App\User::withCount("comments")->orderBy("comments_count","desc")->whereBetween("created_at",array(Carbon::now()->subDays(7),Carbon::today()))->take(12)->get();    //回帖周榜
            $newUsers = \App\User::orderBy("created_at","desc")->take(12)->get();    //新进用户
            $links = \App\FriendLink::where("is_show",1)->orderBy("sort")->get();
            $view->with(compact('hots','comms','newUsers','links'));
        });

        \view()->composer(['layouts.menus','post.index'],function ($view){
            $menus = Cate::orderBy('cate_order')->get();
            $view->with(compact('menus'));
        });

        \view()->composer(['layouts.*','post.*'],function($view){
            $site = SiteConfig::first();
            $view->with(compact('site'));
        });

        \Carbon\Carbon::setLocale('zh');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
