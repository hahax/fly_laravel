@extends('layouts.main')

@section('content')
    <div class="layui-container fly-marginTop fly-user-main">
        @include('layouts.umenu')
        <div class="fly-panel fly-panel-user" pad20>
            <div class="layui-tab layui-tab-brief" lay-filter="user">
                <ul class="layui-tab-title" id="LAY_mine">
                    <a href="/user/setfile"><li>附件管理</li></a>
                    <a href="/user/setfile/pic"><li class="layui-this">图片上传</li></a>
                    <a href="/user/setfile/editpic"><li>图片管理</li></a>
                    <a href="/user/setfile/aethupload"><li>大附件上传</li></a>
                    <a href="/user/setfile/videos"><li>视频管理</li></a>
                    <a href="/user/setfile/videoList"><li>视频列表</li></a>
                </ul>
                <div class="layui-tab-content" style="padding: 20px 0;">
                    <div class="layui-form layui-form-pane layui-tab-item layui-show">
                        <form method="post" action="">
                            {{ csrf_field() }}
                            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                                <legend>单图片上传</legend>
                            </fieldset>

                            <div class="layui-upload">
                                <button type="button" class="layui-btn" id="test1">上传图片</button>
                                <div class="layui-upload-list">
                                    <img class="layui-upload-img" id="demo1">
                                    <p id="demoText"></p>
                                </div>
                            </div>

                            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                                <legend>多图片上传</legend>
                            </fieldset>

                            <div class="layui-upload">
                                <button type="button" class="layui-btn" id="test2">多图片上传</button>
                                <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                                    预览图：
                                    <div class="layui-upload-list" id="demo2"></div>
                                </blockquote>
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
        layui.use('upload', function(){
            var $ = layui.jquery
                ,upload = layui.upload;

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

            //多图片上传
            upload.render({
                elem: '#test2'
                ,url: '/user/uploadPic'
                ,multiple: true
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#demo2').append('<img src="'+ result +'" alt="'+ file.name +'" class="layui-upload-img" style="width: 100%">')
                    });
                }
                ,done: function(res){
                    //上传完毕
                }
            });
        });
    </script>
@endsection
