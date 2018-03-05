
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>帐号设置</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="keywords" content="fly,layui,前端社区">
  <meta name="description" content="Fly社区是模块化前端UI框架Layui的官网社区，致力于为web开发提供强劲动力">
  <link rel="stylesheet" href="/layui/css/layui.css">
  <link rel="stylesheet" href="/css/global.css">
</head>
<body>

@include('layouts.header')

<div class="layui-container fly-marginTop fly-user-main">
  @include('layouts.umenu')

  <div class="site-tree-mobile layui-hide">
    <i class="layui-icon">&#xe602;</i>
  </div>
  <div class="site-mobile-shade"></div>
  
  <div class="site-tree-mobile layui-hide">
    <i class="layui-icon">&#xe602;</i>
  </div>
  <div class="site-mobile-shade"></div>
  
  
  <div class="fly-panel fly-panel-user" pad20>
    <div class="layui-tab layui-tab-brief" lay-filter="user">
      <ul class="layui-tab-title" id="LAY_mine">
        <li class="layui-this" lay-id="info">我的资料</li>
        <li lay-id="avatar">头像</li>
        <li lay-id="pass">密码</li>
        <li lay-id="bind">帐号绑定</li>
      </ul>
      <div class="layui-tab-content" style="padding: 20px 0;">
        <div class="layui-form layui-form-pane layui-tab-item layui-show">
          <form method="post" action="/user/dosetting">
            {{ csrf_field() }}
            <div class="layui-form-item">
              <label for="L_email" class="layui-form-label">邮箱</label>
              <div class="layui-input-inline">
                <input type="text" id="L_email" name="email" readonly required lay-verify="email" autocomplete="off" value="{{$user->email}}" class="layui-input layui-disabled">
              </div>
              <div class="layui-form-mid layui-word-aux">如果您在邮箱已激活的情况下，变更了邮箱，需<a href="/user/activate" style="font-size: 12px; color: #4f99cf;">重新验证邮箱</a>。</div>
            </div>
            <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">昵称</label>
              <div class="layui-input-inline">
                <input type="text" id="L_username" name="name" required lay-verify="required" autocomplete="off" value="{{$user->name}}" class="layui-input">
              </div>
              <div class="layui-inline">
                <div class="layui-input-inline">
                  <input type="radio" name="gender" value="1" @if($user->gender == 1) checked @endif title="男">
                  <input type="radio" name="gender" value="2" @if($user->gender == 2) checked @endif title="女">
                </div>
              </div>
            </div>
            <div class="layui-form-item">
              <label for="L_city" class="layui-form-label">城市</label>
              <div class="layui-input-inline">
                <input type="text" id="L_city" name="city" autocomplete="off" value="" class="layui-input">
              </div>
            </div>
            <div class="layui-form-item layui-form-text">
              <label for="L_sign" class="layui-form-label">签名</label>
              <div class="layui-input-block">
                <textarea placeholder="随便写些什么刷下存在感" id="L_sign"  name="autograph" autocomplete="off" class="layui-textarea" style="height: 80px;">{{$user->autograph}}</textarea>
              </div>
            </div>
            @include('layouts.error')
            <div class="layui-form-item">
              <button class="layui-btn" key="set-mine" lay-filter="*" type="submit">确认修改</button>
            </div>
            </form>
          </div>
        
          <div class="layui-form layui-form-pane layui-tab-item">
            <form method="post">
              <div class="layui-form-item">
                <div class="avatar-add">
                  <p>建议尺寸168*168，支持jpg、png、gif，最大不能超过50KB</p>
                  <button type="button" class="layui-btn upload-img">
                    <i class="layui-icon">&#xe67c;</i>上传头像
                    <input type="file" name="file" class="layui-upload-file" id="image" lay-type="images">
                  </button>
                  <img src="{{$user->avatar}}" id="headimg">
                  <span class="loading"></span>
                </div>
              </div>
            </form>
          </div>
        
          <div class="layui-form layui-form-pane layui-tab-item">
            <form action="/user/repass/{{$user->id}}" method="post">
              {{csrf_field()}}
              <div class="layui-form-item">
                <label for="L_nowpass" class="layui-form-label">当前密码</label>
                <div class="layui-input-inline">
                  <input type="password" id="L_nowpass" name="nowpass" required lay-verify="required|pass" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label">新密码</label>
                <div class="layui-input-inline">
                  <input type="password" id="L_pass" name="password" required lay-verify="required|pass" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">6到16个字符</div>
              </div>
              <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">确认密码</label>
                <div class="layui-input-inline">
                  <input type="password" id="L_repass" name="password_confirmation" required lay-verify="required|pass" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <button class="layui-btn" key="set-mine" lay-filter="*" lay-submit>确认修改</button>
              </div>
            </form>
          </div>
          
          <div class="layui-form layui-form-pane layui-tab-item">
            <ul class="app-bind">
              <li class="fly-msg app-havebind">
                <i class="iconfont icon-qq"></i>
                <span>已成功绑定，您可以使用QQ帐号直接登录Fly社区，当然，您也可以</span>
                <a href="javascript:;" class="acc-unbind" type="qq_id">解除绑定</a>
                
                <!-- <a href="" onclick="layer.msg('正在绑定微博QQ', {icon:16, shade: 0.1, time:0})" class="acc-bind" type="qq_id">立即绑定</a>
                <span>，即可使用QQ帐号登录Fly社区</span> -->
              </li>
              <li class="fly-msg">
                <i class="iconfont icon-weibo"></i>
                <!-- <span>已成功绑定，您可以使用微博直接登录Fly社区，当然，您也可以</span>
                <a href="javascript:;" class="acc-unbind" type="weibo_id">解除绑定</a> -->
                
                <a href="" class="acc-weibo" type="weibo_id"  onclick="layer.msg('正在绑定微博', {icon:16, shade: 0.1, time:0})" >立即绑定</a>
                <span>，即可使用微博帐号登录Fly社区</span>
              </li>
            </ul>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

@include("layouts.footer")

<script src="/layui/layui.js"></script>
<script>
layui.config({
  version: "2.0.0"
  ,base: '/mods/'
}).extend({
  fly: 'index'
}).use('fly');

layui.use(['form', 'upload'], function(){
    var form = layui.form;
    form.verify({
        pass: [/(.+){6,12}$/, '密码必须6到12位']
        ,content: function(value){
            layedit.sync(editIndex);
        }
    });

    var upload = layui.upload;
    //执行实例
    var uploadInst = upload.render({
      elem: '.upload-img',
      url: '/user/uploadImg',
      size: 500,
      done: function(res){
        //上传完毕回调
        $("#headimg").attr('src',res.path);
        $("#tophead").attr('src',res.path);
      }
      ,error: function(){
        //请求异常回调
      }
    });
});
</script>
<script src="/js/jquery.min.js"></script>
<script>//根据ip获取城市
$.getScript('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js', function() {
    $('#L_city').val(remote_ip_info.city || '');
});
</script>
</body>
</html>