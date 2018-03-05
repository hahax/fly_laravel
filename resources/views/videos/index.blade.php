@extends('layouts.main')

@section('content')
    <div class="layui-container fly-marginTop fly-user-main">
        @include('layouts.umenu')
        <div class="fly-panel fly-panel-user" pad20>
            <div class="layui-tab layui-tab-brief" lay-filter="user">
                <ul class="layui-tab-title" id="LAY_mine">
                    <a href="/user/setfile"><li>附件管理</li></a>
                    <a href="/user/setfile/pic"><li>图片上传</li></a>
                    <a href="/user/setfile/editpic"><li>图片管理</li></a>
                    <a href="/user/setfile/aethupload"><li>大附件上传</li></a>
                    <a href="/user/setfile/videos"><li class="layui-this">视频管理</li></a>
                    <a href="/user/setfile/videoList"><li>视频列表</li></a>
                </ul>
                <div class="layui-tab-content" style="padding: 20px 0;">
                    <div class="layui-form layui-form-pane layui-tab-item layui-show">
                        @if(env("VIDEOS_PAGE") == "local")
                            <form method="post" action="/user/dosetting">
                                {{ csrf_field() }}
                                <button type="button" class="layui-btn" id="test5"><i class="layui-icon"></i>上传视频</button>
                            </form>
                            @else
                            <form action="/user/uploadVideo" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <button type="button" class="layui-btn" id="upbtn1">
                                    <i class="layui-icon">&#xe67c;</i>
                                    上传文件
                                </button>
                                <input type="file" name="video" id="video" onchange="makecolor()"/>
                                <br><br>
                                <button type="submit" class="layui-btn layui-btn-normal">提交</button>
                            </form>
                        @endif
                    </div>
                    <br>
                    @include("layouts.error")
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
                            @foreach($videos as $v)
                                <tr>
                                    <td >{{$v->id}}</td>
                                    <td >{{$v->file_type}}</td>
                                    <td >{{str_limit(urldecode($v->name),60)}}</td>
                                    <td>
                                        <div class="layui-btn-group">
                                            <a href="/user/downVideo/{{ $v->id }}">
                                                <button class="layui-btn layui-btn-sm">
                                                    <i class="layui-icon">&#xe64c;</i>下载
                                                </button>
                                            </a>
                                            <a href="/user/delVideo/{{$v->id}}" style="margin-left: 10px">
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
                                {{$videos->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/layui/layui.js" charset="utf-8"></script>
    <script src="/js/jquery.min.js"></script>
    <style>
        #upbtn1{
            position: relative;
            display: inline-block;
            background: #D0EEFF;
            border: 1px solid #99D3F5;
            border-radius: 4px;
            padding: 4px 12px;
            overflow: hidden;
            color: #1E88C7;
            text-decoration: none;
            text-indent: 0;
            line-height: 20px;
            cursor: pointer
        }
        #video{
            position: relative;
            font-size: 23px;
            left: -110px;
            top: 5px;
            opacity: 0;
            cursor: pointer
        }
    </style>
    <script>
        makecolor = function () {
            document.getElementById("upbtn1").innerText = "请点击提交";
        }
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
        });
        layui.use('upload', function(){
            var $ = layui.jquery
                ,upload = layui.upload;
            var index;
            //指定允许上传的文件类型
            upload.render({
                elem: '#test5'
                ,url: '/user/uploadVideo'
                ,accept: 'video' //视频
                ,multiple: true
                // ,size:100000
                ,before:function (res) {
                    index = layer.load(1, {
                        shade: [0.3,'#fff'] //0.1透明度的白色背景
                    });
                }
                ,done: function(res){
                    layer.close(index);
                    layer.msg(res.msg);
                    setTimeout("location.reload()",1000);
                    console.log(res)
                }
            });
        });
    </script>
@endsection
