@extends('layouts.main')

@section('content')
    <div class="layui-container fly-marginTop fly-user-main">
        @include('layouts.umenu')
        <div class="fly-panel fly-panel-user" pad20>
            <div class="layui-tab layui-tab-brief" lay-filter="user">
                <ul class="layui-tab-title" id="LAY_mine">
                    <a href="/user/setting"><li>我的资料</li></a>
                    <a href="/user/setting/avatar"><li class="layui-this">头像</li></a>
                    <a href="/user/setting/pass"><li>密码</li></a>
                    {{--<li lay-id="bind">帐号绑定</li>--}}
                </ul>
                <div class="layui-tab-content" style="padding: 20px 0;">
                    <div class="layui-form layui-form-pane layui-tab-item layui-show">
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
                size: 5000,
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

@endsection
