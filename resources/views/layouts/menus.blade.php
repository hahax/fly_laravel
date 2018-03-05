<div class="fly-panel fly-column">
  <div class="layui-container">
    <ul class="layui-clear">
      <li class="layui-hide-xs @if(!isset($path)) layui-this @endif"><a href="/">首页</a></li>
      @foreach($menus as $menu)
        <li @if($menu->id == $path && \Request::segment(2)=='index') class="layui-this" @endif><a href="/posts/index/{{$menu->id}}">{{$menu->cate_name}}</a></li>
      @endforeach
      <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><span class="fly-mid"></span></li> 
      
      <!-- 用户登入后显示 -->
      @if(Auth::check())
      <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><a href="/user/index/{{$user->id}}">我的帖子</a></li>
      {{--<li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><a href="/user/index/{{$user->id}}#collection">我收藏的贴</a></li>--}}
      @endif
    </ul> 
    
    <div class="fly-column-right layui-hide-xs"> 
      <span class="fly-search"><i class="layui-icon"></i></span>
      @if($site->forum_sh == 1 || \App\User::isSuperAdmin())
      <a href="/posts/create" class="layui-btn">发表新帖</a>
        @else
        <a href="#" class="layui-btn layui-disabled">管理员已禁止发帖</a>
      @endif
    </div> 
    <div class="layui-hide-sm layui-show-xs-block" style="margin-top: -10px; padding-bottom: 10px; text-align: center;">
      @if($site->forum_sh == 1 || \App\User::isSuperAdmin())
      <a href="/posts/create" class="layui-btn">发表新帖</a>
      @else
        <a href="#" class="layui-btn layui-disabled">管理员已禁止发帖</a>
      @endif
    </div> 
  </div>
</div>