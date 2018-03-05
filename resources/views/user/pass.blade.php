@extends('layouts.main')

@section('content')
    <div class="layui-container fly-marginTop fly-user-main">
        @include('layouts.umenu')
        <div class="fly-panel fly-panel-user" pad20>
            <div class="layui-tab layui-tab-brief" lay-filter="user">
                <ul class="layui-tab-title" id="LAY_mine">
                    <a href="/user/setting"><li>我的资料</li></a>
                    <a href="/user/setting/avatar"><li>头像</li></a>
                    <a href="/user/setting/pass"><li class="layui-this">密码</li></a>
                    {{--<li lay-id="bind">帐号绑定</li>--}}
                </ul>
                <div class="layui-tab-content" style="padding: 20px 0;">
                    <div class="layui-form layui-form-pane layui-tab-item layui-show">
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
                            @include("layouts.error")
                            <div class="layui-form-item">
                                <button class="layui-btn" key="set-mine" lay-filter="*" lay-submit>确认修改</button>
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
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
        });
        layui.use('table', function(){
            var table = layui.table
                ,form = layui.form;

            form.verify({
                pass: [/(.+){6,12}$/, '密码必须6到12位']
                ,content: function(value){
                    layedit.sync(editIndex);
                }
            });

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
