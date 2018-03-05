@extends('layouts.main')

@section('content')
    <div class="layui-container fly-marginTop fly-user-main">
        @include('layouts.umenu')
        <div class="fly-panel fly-panel-user" pad20>
            <div class="layui-tab layui-tab-brief" lay-filter="user">
                <ul class="layui-tab-title" id="LAY_mine">
                    <a href="/user/setting"><li class="layui-this">我的资料</li></a>
                    <a href="/user/setting/avatar"><li>头像</li></a>
                    <a href="/user/setting/pass"><li>密码</li></a>
                    {{--<li lay-id="bind">帐号绑定</li>--}}
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
                </div>
            </div>
        </div>
    </div>
    <script src="/layui/layui.js" charset="utf-8"></script>
    <script src="/js/jquery.min.js"></script>
    <script>
        //根据ip获取城市
        $.getScript('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js', function() {
            $('#L_city').val(remote_ip_info.city || '');
        });
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
        });
        layui.use('table', function(){
            var table = layui.table
                ,form = layui.form;

            form.on('switch(is_show)', function(obj){
                var is_show = 0;
                if(obj.elem.checked == true)
                {
                    is_show = 1;
                }
                var id = this.value;
                var url="/user/editLink";
                $.ajax({
                    url : url,
                    type : "post",
                    dataType : "json",
                    data: {'id':id,'data':is_show,'type':'is_show'},
                    success : function(res) {
                        if(res.code==200) {
                            layer.alert(res.msg);
                        } else {
                            layer.alert("出错了！！请检查后重试",{title:'错误提示',icon:0});
                        }
                    },
                    error:function (msg) {
                        layer.alert("出错了！！请检查后重试",{title:'错误提示',icon:0});
                    },
                });
            });
        });
    </script>
@endsection
@section('js')
    @include("layouts.js")
@endsection