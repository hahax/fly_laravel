<div class="fly-header layui-bg-black">
  <div class="layui-container">
    <a class="fly-logo" href="/">
      <img src="/images/logo.png" alt="layui">
    </a>
    <ul class="layui-nav fly-nav layui-hide-xs">
      <li class="layui-nav-item @if($path !== 'case') layui-this @endif">
        <a href="/"><i class="iconfont icon-jiaoliu"></i>交流</a>
      </li>
      <li class="layui-nav-item @if($path == 'case') layui-this @endif">
        <a href="/case/case"><i class="iconfont icon-iconmingxinganli"></i>案例</a>
      </li>
      {{--<li class="layui-nav-item">--}}
        {{--<a href="http://www.layui.com/" target="_blank"><i class="iconfont icon-ui"></i>框架</a>--}}
      {{--</li>--}}
    </ul>
    
    <ul class="layui-nav fly-nav-user">
      @if(isset($user))
        <!-- 登入后的状态 -->
        <li class="layui-nav-item">
          <a class="fly-nav-avatar" href="javascript:;">
            <cite class="layui-hide-xs">{{$user->name}}</cite>
            <i class="iconfont icon-renzheng layui-hide-xs" title="认证信息：已激活邮箱"></i>
            @if(\App\User::isSuperAdmin())
              <i class="layui-badge fly-badge-vip layui-hide-xs">管理员</i>
            @endif
            <img src="{{ ($user->avatar!=="") ? $user->avatar : \App\User::DEFAVA }}" id="tophead">
          </a>
          <dl class="layui-nav-child">
            <dd><a href="/user/setting"><i class="layui-icon">&#xe620;</i>基本设置</a></dd>
            {{--<dd><a href="/user/message"><i class="iconfont icon-tongzhi" style="top: 4px;"></i>我的消息</a></dd>--}}
            <dd><a href="/user/home/{{$user->id}}"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe68e;</i>我的主页</a></dd>

            @if(\App\User::isSuperAdmin())
              <dd><a href="/user/setlink"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe64c;</i>友情链接</a></dd>
              <dd><a href="/user/setsite"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe620;</i>网站设置</a></dd>
              <dd><a href="/user/setcate"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe630;</i>社区板块</a></dd>
              <dd><a href="/user/setfile"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe67c;</i>上传附件</a></dd>
              <dd><a href="/user/case"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe705;</i>案例</a></dd>
            @endif

            <hr style="margin: 5px 0;">
            <dd><a href="/logout/" style="text-align: center;">退出</a></dd>
          </dl>
        </li>
      @else
        <!-- 未登入的状态 -->
        <li class="layui-nav-item">
          <a class="iconfont icon-touxiang layui-hide-xs" href="/login"></a>
        </li>
        <li class="layui-nav-item">
          <a href="/login">登入</a>
        </li>
        <li class="layui-nav-item">
          <a href="/register">注册</a>
        </li>
        {{--<li class="layui-nav-item layui-hide-xs">--}}
          {{--<a href="/app/qq/" onclick="layer.msg('正在通过QQ登入', {icon:16, shade: 0.1, time:0})" title="QQ登入" class="iconfont icon-qq"></a>--}}
        {{--</li>--}}
        {{--<li class="layui-nav-item layui-hide-xs">--}}
          {{--<a href="/app/weibo/" onclick="layer.msg('正在通过微博登入', {icon:16, shade: 0.1, time:0})" title="微博登入" class="iconfont icon-weibo"></a>--}}
        {{--</li>--}}
      @endif
    </ul>
  </div>
</div>