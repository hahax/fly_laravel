@extends('layouts.main')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}"><!--需要有csrf token-->
    <div class="layui-container fly-marginTop fly-user-main">
        @include('layouts.umenu')
        <div class="fly-panel fly-panel-user" pad20>
            <div class="layui-tab layui-tab-brief" lay-filter="user">
                <ul class="layui-tab-title" id="LAY_mine">
                    <a href="/user/setfile"><li>附件管理</li></a>
                    <a href="/user/setfile/pic"><li>图片上传</li></a>
                    <a href="/user/setfile/editpic"><li>图片管理</li></a>
                    <a href="/user/setfile/aethupload"><li class="layui-this">大附件上传</li></a>
                    <a href="/user/setfile/videos"><li>视频管理</li></a>
                    <a href="/user/setfile/videoList"><li>视频列表</li></a>
                </ul>
                <div class="layui-tab-content" style="padding: 20px 0;">
                    <div class="layui-tab layui-tab-brief" lay-filter="user">
                        <div class="row">
                            <form method="post" action="/user/setfile/aethupload" class="layui-form">
                                {{csrf_field()}}
                                <div class="form-group " id="aetherupload-wrapper" ><!--组件最外部需要有一个名为aetherupload-wrapper的id，用以包装组件-->
                                    <div class="controls">
                                        <button type="button" class="layui-btn" id="upbtn1">
                                            <i class="layui-icon">&#xe67c;</i>上传文件
                                        </button>
                                        <input type="file" id="file"  onchange="aetherupload(this,'file').success(someCallback).upload()"/><!--需要有一个名为file的id，用以标识上传的文件，aetherupload(file,group)中第二个参数为分组名，success方法可用于声名上传成功后的回调方法名-->
                                        <span style="font-size:12px;color:#aaa;display: block;margin-top:10px;" id="output"></span>
                                        <input type="hidden" name="path" id="savedpath" >
                                        {{--<!--需要有一个名为savedpath的id，用以标识文件保存路径的表单字段，还需要一个任意名称的name-->--}}
                                    </div>
                                    <div class="layui-form-item">
                                        <div class="layui-input-block" style="margin-left: 0 !important;">
                                            <input type="radio" name="type" value="file" title="文件">
                                            <input type="radio" name="type" value="video" title="视频" checked>
                                        </div>
                                    </div>
                                    {{--<div class="layui-form-item">--}}
                                        {{--<div class="layui-input-block" style="margin-left: 0 !important;width: 20%;min-width: 150px;">--}}
                                            {{--<select name="video_cate" lay-verify="required">--}}
                                                {{--<option value=""></option>--}}
                                                {{--@foreach($cate as $v)--}}
                                                    {{--<option value="{{$v->id}}">{{$v->cate_name}}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                </div>

                                <input type="hidden" name="name" id="picname">
                                <input type="hidden" name="size" id="picsize">
                                <button type="submit" class="layui-btn btn-primary layui-btn-disabled" id="sub">点击提交</button>
                                <a href="/user/clearAeth" class="layui-btn layui-btn-danger">清空暂存列表</a>
                            </form>
                            @include("layouts.error")
                            <hr/>
                            <div id="result"></div>
                        </div>
                    </div>
                    <div class="layui-tab layui-tab-brief" lay-filter="user">
                        <table class="layui-table" lay-size="lg" lay-filter="link">
                            <colgroup>
                                <col width="100">
                                <col>
                                <col>
                                <col width="200">
                            </colgroup>
                            <thead>
                            <tr>
                                <th lay-data="{sort: true}">序号</th>
                                <th lay-data="{sort: true}">文件名称</th>
                                <th lay-data="{sort: true}">文件大小</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($aeths as $v)
                                <tr>
                                    <td >{{$v->id}}</td>
                                    <td >{{ str_limit(urldecode($v->name),50) }}</td>
                                    <td >{{$v->size}}</td>
                                    <td>
                                        <div class="layui-btn-group">
                                            @if($v->type == 2)
                                                <a href="{{$v->path}}">
                                                @else
                                                <a href="/user/downaeth/{{ $v->id }}">
                                            @endif
                                                <button class="layui-btn layui-btn-sm">
                                                    <i class="layui-icon">&#xe64c;</i>下载
                                                </button>
                                            </a>
                                            <a href="/user/delaeth/{{$v->id}}" style="margin-left: 10px">
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
                                {{$aeths->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/layui/layui.js" charset="utf-8"></script>
    <script src="{{ URL::asset('js/spark-md5.min.js') }}"></script><!--需要引入spark-md5.min.js-->
    <script src="/js/jquery.min.js"></script>
    <script src="{{ URL::asset('js/aetherupload.js') }}"></script><!--需要引入aetherupload.js-->
    <script src="/layui/layui.js" charset="utf-8"></script>
    <script>
        someCallback = function(){
            $("#file").attr("disabled");
            $("#sub").attr("class","layui-btn btn-primary");
            $("#output").html(this.fileName+"上传成功，请点击提交");
            $("#picname").val(this.fileName);
            $("#picsize").val(parseFloat(this.fileSize / (1000 * 1000)).toFixed(2)+"M");
        }
    </script>
    <style>
        @media screen and (max-width: 800px){
            #upbtn1{display: none}
        }
        @media screen and (min-width: 800px) {
            #sub{margin: 10px 0}
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
            #file{
                position: relative;
                font-size: 23px;
                left: -110px;
                top: 5px;
                opacity: 0;
                cursor: pointer
            }
        }
    </style>
@endsection
@section('js')
    @include("layouts.js")
@endsection
