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
                        <form class="layui-form" action="/user/createCate" method="post">
                            {{csrf_field()}}
                            <div class="layui-form-item">
                                <label class="layui-form-label">排序</label>
                                <div class="layui-input-block">
                                    <input type="text" name="cate_order" placeholder="请输入" autocomplete="off" class="layui-input" value="{{old('cate_order')}}" required lay-verify="required">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">板块名称</label>
                                <div class="layui-input-block">
                                    <input type="text" name="cate_name" placeholder="请输入" autocomplete="off" class="layui-input" value="{{old('cate_name')}}" required lay-verify="required">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">关键字</label>
                                <div class="layui-input-block">
                                    <input type="text" name="cate_key" placeholder="请输入" autocomplete="off" class="layui-input" value="{{old('cate_key')}}">
                                </div>
                            </div>
                            <div class="layui-form-item layui-form-text">
                                <label class="layui-form-label">描述</label>
                                <div class="layui-input-block">
                                    <textarea placeholder="请输入内容" name="description" class="layui-textarea">{{old('description')}}</textarea>
                                </div>
                            </div>
                            @include("layouts.error")
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <button class="layui-btn" type="submit" lay-filter="*">立即提交</button>
                                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
    @include("layouts.js")
@endsection
