<ul class="layui-nav layui-nav-tree layui-inline" lay-filter="user">
    <li class="layui-nav-item @if($path == 'home') layui-this @endif">
        <a href="/user/home/{{$user->id}}">
            <i class="layui-icon">&#xe609;</i> 我的主页
        </a>
    </li>
    <li class="layui-nav-item @if($path == 'index') layui-this @endif">
        <a href="/user/index/{{$user->id}}">
            <i class="layui-icon">&#xe612;</i> 我的帖子
        </a>
    </li>
    <li class="layui-nav-item @if($path == 'setting' || $path == 'activate') layui-this @endif">
        <a href="/user/setting">
            <i class="layui-icon">&#xe620;</i> 基本设置
        </a>
    </li>
    {{--<li class="layui-nav-item @if($path == 'message') layui-this @endif">--}}
        {{--<a href="/user/message">--}}
            {{--<i class="layui-icon">&#xe611;</i> 我的消息--}}
        {{--</a>--}}
    {{--</li>--}}
    @if(\App\User::isSuperAdmin())
        <li class="layui-nav-item"><a href=""><i class="layui-icon">&#xe61a;</i>管理模块&nbsp;&nbsp;<i class="layui-icon">&#xe61a;</i></a></li>
        <li class="layui-nav-item @if($path == 'setlink') layui-this @endif">
            <a href="/user/setlink">
                <i class="layui-icon">&#xe64c;</i> 友情链接
            </a>
        </li>
        <li class="layui-nav-item @if($path == 'setsite') layui-this @endif">
            <a href="/user/setsite">
                <i class="layui-icon">&#xe614;</i> 网站设置
            </a>
        </li>
        <li class="layui-nav-item @if($path == 'setcate') layui-this @endif">
            <a href="/user/setcate">
                <i class="layui-icon">&#xe630;</i> 社区板块
            </a>
        </li>
        <li class="layui-nav-item @if($path == 'setfile') layui-this @endif">
            <a href="/user/setfile">
                <i class="layui-icon">&#xe67c;</i> 上传附件
            </a>
        </li>
        <li class="layui-nav-item @if($path == 'case') layui-this @endif">
            <a href="/user/case">
                <i class="layui-icon">&#xe705;</i> 案例
            </a>
        </li>
    @endif
</ul>

<div class="site-tree-mobile layui-hide">
    <i class="layui-icon">&#xe602;</i>
</div>
<div class="site-mobile-shade"></div>

<div class="site-tree-mobile layui-hide">
    <i class="layui-icon">&#xe602;</i>
</div>
<div class="site-mobile-shade"></div>