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
                    <li data-type="mine-jie" lay-id="index" class="layui-this">编辑案例</li>
                </ul>

                <div class="layui-tab-content" style="padding: 20px 0;">
                    <div class="layui-tab-item layui-show">
                        <form class="layui-form " action="/user/editCase/{{$cases->id}}" method="post">
                            {{csrf_field()}}
                            <div class="layui-form-item">
                                <label class="layui-form-label">排序</label>
                                <div class="layui-input-block">
                                    <input type="text" name="case_sort" placeholder="请输入" autocomplete="off" class="layui-input" value="{{$cases->case_sort}}" lay-verify="number">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">案例名称</label>
                                <div class="layui-input-block">
                                    <input type="text" name="title" placeholder="请输入" autocomplete="off" class="layui-input" value="{{$cases->title}}" lay-verify="name">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">案例简介</label>
                                <div class="layui-input-block">
                                    <input type="text" name="content" placeholder="请输入" autocomplete="off" class="layui-input" value="{{$cases->content}}" lay-verify="required|name">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">网站地址</label>
                                <div class="layui-input-block">
                                    <input type="text" name="http_path" lay-verify="url" placeholder="请输入" autocomplete="off" class="layui-input" value="{{$cases->http_path}}">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">git地址</label>
                                <div class="layui-input-block">
                                    <input type="text" name="git_path" lay-verify="url" placeholder="请输入" autocomplete="off" class="layui-input" value="{{$cases->git_path}}">
                                </div>
                            </div>
                            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                                <legend>案例图片上传</legend>
                            </fieldset>
                            <div class="layui-upload" style="margin-bottom: 20px">
                                <button type="button" class="layui-btn" id="test1" style="vertical-align: top;"><i class="layui-icon">&#xe608;</i>案例图片</button>
                                <div class="layui-upload-list" style="display: inline-block;width: 200px;margin-left: 10px;margin-top:0px">
                                    <img class="layui-upload-img" id="demo1" style="width: 200px;height: 200px;" src="{{$cases->pic_path}}">
                                    <input type="hidden" name="pic_path" id="pic_path" value="{{$cases->pic_path}}">
                                    <p id="demoText"></p>
                                </div>
                            </div>
                            @include("layouts.error")
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <button class="layui-btn" lay-submit="" lay-filter="demo2">立即提交</button>
                                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
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
        layui.use(['form', 'layedit', 'laydate','upload'], function(){
            var form = layui.form
                ,layer = layui.layer
                ,layedit = layui.layedit
                ,laydate = layui.laydate
                ,upload = layui.upload;
            //各种基于事件的操作，下面会有进一步介绍
            form.verify({
                name: function(value){
                    if(value.length < 2){
                        return '名称至少两个字符';
                    }
                }
            });
            //普通图片上传
            var uploadInst = upload.render({
                elem: '#test1'
                // ,url: '/user/uploadPic'
                ,url: '/user/uploadPic'
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#demo1').attr('src', result); //图片链接（base64）
                    });
                }
                ,done: function(res){
                    //如果上传失败
                    if(res.code > 0){
                        return layer.msg('上传失败');
                    }
                    //上传成功
                    $('#demo1').attr('src', res.path);
                    $('#demo1').show();
                    $('#pic_path').val(res.path);
                }
                ,error: function(){
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst.upload();
                    });
                }
            });
        });
    </script>
@endsection
