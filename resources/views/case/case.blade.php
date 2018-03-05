@extends("layouts.main")

@section("content")
<div class="fly-case-header">
    <p class="fly-case-year">{{date('Y')}}</p>
    <a href="/case/case">
        <p class="fly-case-banner" style="font-size: 55px;color: #ffffff;">我的案例</p>
    </a>
    {{--<div class="fly-case-btn">--}}
        {{--<a href="javascript:;" class="layui-btn layui-btn-big fly-case-active" data-type="push">提交案例</a>--}}
        {{--<a href="" class="layui-btn layui-btn-primary layui-btn-big">我的案例</a>--}}

        {{--<a href="http://fly.layui.com/jie/11996/" target="_blank" style="padding: 0 15px; text-decoration: underline">案例要求</a>--}}
    {{--</div>--}}
</div>

<div class="fly-main" style="overflow: hidden;">
    <div class="layui-tab layui-tab-brief">
        <ul class="layui-tab-title">
            <li class="layui-this"><a href="#">我的案例</a></li>
        </ul>
    </div>

    @if(count($cases)>0)
    <ul class="fly-case-list">
        @foreach($cases as $case)
        <li data-id="123">
            <a class="fly-case-img" href="{{$case->http_path}}" target="_blank" >
                <img src="{{$case->pic_path or '/uploads/default.jpg'}}" alt="{{$case->title}}">
                <cite class="layui-btn layui-btn-primary layui-btn-small">去围观</cite>
            </a>
            <h2><a href="{{$case->http_path}}" target="_blank">{{str_limit($case->title,22)}}</a></h2>
            <p class="fly-case-desc">{{str_limit($case->content,110)}}</p>
            <div class="fly-case-info">
                <a href="/user/home/{{$admin->id}}" class="fly-case-user" target="_blank"><img src="{{$admin->avatar}}"></a>
                <p class="layui-elip" style="font-size: 12px;"><span style="color: #666;">{{$admin->name}}</span> {{$case->created_at->toDateString()}}</p>
                <p>获得<a class="fly-case-nums fly-case-active" href="javascript:;" data-type="showPraise" style=" padding:0 5px; color: #01AAED;">666</a>个赞</p>
                <a href="{{$case->git_path}}" target="_blank"><button class="layui-btn layui-btn-primary fly-case-active" data-type="praise">Gitee</button></a>
            </div>
        </li>
        @endforeach

    </ul>
    @else
    <blockquote class="layui-elem-quote layui-quote-nm">暂无数据</blockquote>
    @endif
    <div style="text-align: center">
        <div class="laypage-main">
            {{$cases->links()}}
        </div>
    </div>
</div>
@endsection
@section('js')
    @include("layouts.js")
@endsection
