@extends('layouts.main')

@section('content')
<div class="fly-home fly-panel" style="background-image: url();">
    <img src="{{ ($user->avatar!=="") ? $user->avatar : \App\User::DEFAVA }}" alt="{{$user->name}}">
    <i class="iconfont icon-renzheng" title="社区认证"></i>
    <h1>
        {{$user->name}}
        <i class="iconfont @if($user->gender == 1) icon-nan @elseif($user->gender == 2) icon-nv @else @endif"></i>
        <!-- <i class="iconfont icon-nv"></i>  -->
        {{--<i class="layui-badge fly-badge-vip">VIP3</i>--}}
        @if($user->isadmin == 1 && $user->id == 1)
            <span style="color:#c00;">（管理员）</span>
        @endif
        <span style="color:#5FB878;">（社区之光）</span>
        <!--<span>（该号已被封）</span>
        -->
    </h1>
    @if(\App\User::isSuperAdmin())
        <p style="padding: 10px 0; color: #5FB878;">认证信息：社区管理员</p>
    @endif
    <p class="fly-home-info">
        <a href=""><i class="layui-icon">&#xe63c;</i><span style="color: #FF7200;">私信他</span></a>
        <i class="iconfont icon-shijian"></i><span>{{$user->created_at->toDateString()}} 加入</span>
        <i class="iconfont icon-chengshi"></i><span>来自<span id="L_city"></span></span>
    </p>

    <p class="fly-home-sign">（{{$user->autograph or "这个用户还没有签名"}}）</p>

    {{--<div class="fly-sns" data-user="">--}}
        {{--<a href="javascript:;" class="layui-btn layui-btn-primary fly-imActive" data-type="addFriend">加为好友</a>--}}
        {{--<a href="javascript:;" class="layui-btn layui-btn-normal fly-imActive" data-type="chat">发起会话</a>--}}
    {{--</div>--}}

</div>
<div class="layui-container">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md6 fly-home-jie">
            <div class="fly-panel">
                <h3 class="fly-panel-title">{{$user->name}} 最近的文章</h3>
                <ul class="jie-row">
                    @if(count($posts)>0)
                        @foreach($posts as $post)
                        <li>
                            @if($post->rsuv == 1)
                            <span class="fly-jing">精</span>
                            @endif
                            <a href="/posts/show/{{$post->id}}" class="jie-title"> {{$post->title}}</a>
                            <i>{{$post->created_at->diffForHumans()}}</i>
                            <em class="layui-hide-xs">{{$post->view_count}}阅/{{$post->comments_count}}答</em>
                        </li>
                        @endforeach
                    @else
                        <div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><i style="font-size:14px;">没有发表任何文章</i></div>
                    @endif
                </ul>
            </div>
        </div>

        <div class="layui-col-md6 fly-home-da">
            <div class="fly-panel">
                <h3 class="fly-panel-title">{{$user->name}} 最近的回答</h3>
                <ul class="home-jieda">
                    @if(count($comments)>0)
                        @foreach($comments as $com)
                            @if(isset($com->post->id))
                            <li>
                                <p>
                                    <span>{{$com->created_at->diffForHumans()}}</span> 在
                                    <a href="/posts/show/{{$com->post->id}}" target="_blank">{{$com->post->title}}</a>中回答：
                                </p>
                                <div class="home-dacontent">
                                   {!! str_limit(EndaEditor::MarkDecode($com->content),1000) !!}
                                </div>
                            </li>
                            @endif
                        @endforeach
                    @else
                        <div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><span>没有回答任何问题</span></div>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@include('layouts.city')
@endsection
@section('js')
    @include("layouts.js")
@endsection
