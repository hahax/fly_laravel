@extends('layouts.main')

@section('content')
    <div class="layui-container fly-marginTop fly-user-main">
        @include('layouts.umenu')
        <div class="fly-panel fly-panel-user" pad20>
            <div class="layui-tab layui-tab-brief" lay-filter="user">
                <ul class="layui-tab-title" id="LAY_mine">
                    <a href="/user/setfile"><li class="layui-this">附件管理</li></a>
                    <a href="/user/setfile/pic"><li>图片管理</li></a>
                    <a href="/user/setfile/editpic"><li>图片管理</li></a>
                    <a href="/user/setfile/aethupload"><li>大附件上传</li></a>
                    <a href="/user/setfile/videos"><li>视频管理</li></a>
                    <a href="/user/setfile/videoList"><li>视频列表</li></a>
                </ul>
                <div class="layui-tab-content" style="padding: 20px 0;">
                    <div class="layui-form layui-form-pane layui-tab-item layui-show">
                        <form method="post" action="/user/dosetting">
                            {{ csrf_field() }}
                            <button type="button" class="layui-btn" id="test3"><i class="layui-icon"></i>上传文件</button>
                            <button type="button" class="layui-btn layui-btn-primary" id="test4"><i class="layui-icon"></i>只允许压缩文件</button>
                            <button type="button" class="layui-btn" id="test5"><i class="layui-icon"></i>上传视频</button>
                            <button type="button" class="layui-btn" id="test6"><i class="layui-icon"></i>上传音频</button>
                        </form>
                    </div>
                    <div class="layui-tab layui-tab-brief" lay-filter="user">
                        <table class="layui-table" lay-size="lg" lay-filter="link">
                            <colgroup>
                                <col width="80">
                                <col>
                                <col>
                                <col width="200">
                            </colgroup>
                            <thead>
                            <tr>
                                <th lay-data="{sort: true}">序号</th>
                                <th lay-data="{sort: true}">文件类型</th>
                                <th lay-data="{sort: true, edit: 'text'}">名称</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($files as $link)
                                <tr>
                                    <td >{{$link->id}}</td>
                                    <td >{{$link->file_type}}</td>
                                    <td >{{str_limit(urldecode($link->file_name),60)}}</td>
                                    <td>
                                        <div class="layui-btn-group">
                                            <a href="/user/downfile/{{ $link->id }}">
                                                <button class="layui-btn layui-btn-sm">
                                                    <i class="layui-icon">&#xe64c;</i>下载
                                                </button>
                                            </a>
                                            <a href="/user/delFile/{{$link->id}}" style="margin-left: 10px">
                                                <button class="layui-btn layui-btn-sm" >
                                                    <i class="layui-icon">&#xe640;</i>删除
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            <div class="laypage-main">
                                {{$files->links()}}
                            </div>
                        </div>
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

            //指定允许上传的文件类型
            upload.render({
                elem: '#test3'
                ,url: '/user/uploadFile'
                ,accept: 'file' //普通文件
                ,done: function(res){
                    layer.msg(res.msg)
                    console.log(res)
                }
            });
            upload.render({ //允许上传的文件后缀
                elem: '#test4'
                ,url: '/user/uploadFile'
                ,accept: 'file' //普通文件
                ,exts: 'zip|rar|7z' //只允许上传压缩文件
                ,done: function(res){
                    layer.msg(res.msg)
                    console.log(res)
                }
            });
            upload.render({
                elem: '#test5'
                ,url: '/user/uploadVideo'
                ,accept: 'video' //视频
                ,size:100000
                ,done: function(res){
                    layer.msg(res.msg)
                    console.log(res)
                }
            });
            upload.render({
                elem: '#test6'
                ,url: '/user/uploadFile'
                ,accept: 'audio' //音频
                ,exts:'flac|mp3|mp4'
                ,size:10000
                ,done: function(res){
                    layer.msg(res.msg)
                    console.log(res)
                }
            });
        });
    </script>
@endsection
