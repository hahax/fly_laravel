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
                    <li data-type="mine-jie" lay-id="index" class="layui-this">新建板块</li>
                </ul>

                <div class="layui-tab-content" style="padding: 20px 0;">
                    <div class="layui-tab-item layui-show">
                        <form class="layui-form " action="/user/createLink" method="post">
                            {{csrf_field()}}
                            <div class="layui-form-item">
                                <label class="layui-form-label">排序</label>
                                <div class="layui-input-block">
                                    <input type="text" name="sort" placeholder="请输入" autocomplete="off" class="layui-input" value="" lay-verify="required|number">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">友链名称</label>
                                <div class="layui-input-block">
                                    <input type="text" name="name" placeholder="请输入" autocomplete="off" class="layui-input" value="" required lay-verify="name">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">友链地址</label>
                                <div class="layui-input-block">
                                    <input type="text" name="link" lay-verify="url|required" placeholder="请输入" autocomplete="off" class="layui-input" value="">
                                </div>
                            </div>
                            <div class="layui-form-item layui-form-text">
                                <label class="layui-form-label">是否显示</label>
                                <div class="layui-input-block">
                                    <input type="checkbox" checked="" name="is_show" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
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
    {{--<script src="/js/jquery.min.js"></script>--}}
    <script>
        layui.use(['form', 'layedit', 'laydate'], function(){
            var form = layui.form
            ,layer = layui.layer
            ,layedit = layui.layedit
            ,laydate = layui.laydate;
            //各种基于事件的操作，下面会有进一步介绍
            form.verify({
                name: function(value){
                    if(value.length < 2){
                        return '名称至少两个字符';
                    }
                }
                // ,pass: [/(.+){6,12}$/, '密码必须6到12位']
                // ,content: function(value){
                //     layedit.sync(editIndex);
                // }
            });
        });
    </script>
@endsection
