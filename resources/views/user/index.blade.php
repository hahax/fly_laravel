@extends('layouts.main')

@section('content')
<div class="layui-container fly-marginTop fly-user-main">
    @include('layouts.umenu')
    <div class="fly-panel fly-panel-user" pad20>
        <!--
<div class="fly-msg" style="margin-top: 15px;">
    您的邮箱尚未验证，这比较影响您的帐号安全，<a href="activate.html">立即去激活？</a>
</div>
-->
        <div class="layui-tab layui-tab-brief" lay-filter="user">
            <ul class="layui-tab-title" id="LAY_mine">
                <a href="/user/index/{{$user->id}}"><li data-type="mine-jie" lay-id="index" class="layui-this">我发的帖（<span>{{$num->posts_count}}</span>）</li></a>
                <a href="/user/index/coll/{{$user->id}}"><li data-type="collection" data-url="/collection/find/" lay-id="collection">我收藏的帖（<span>{{$collNum->collection_count}}</span>）</li></a>
            </ul>
            <div class="layui-tab-content" style="padding: 20px 0;">
                <div class="layui-tab-item layui-show">
                    <ul class="mine-view jie-row">
                        @if(count($posts)>0)
                            @foreach($posts as $post)
                                <li>
                                    <a class="jie-title" href="/posts/show/{{$post->id}}" target="_blank">{{$post->title}}</a>
                                    <i>{{$post->created_at->diffForHumans()}}</i>
                                    @if(Auth::user()->can('update',$post))
                                        <a class="mine-edit" href="/posts/{{$post->id}}/edit">编辑</a>
                                        <a class="mine-edit" href="/posts/{{$post->id}}/downMd">下载该页md</a>
                                    @endif
                                    <em>661阅/10答</em>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                    {{--  <div id="LAY_page"></div>  --}}
                    <div style="text-align: center">
                        <div class="laypage-main">
                            @if(count($posts)>0)
                                {{$posts->links()}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    @include("layouts.js")
@endsection
