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
                    <li data-type="mine-jie" lay-id="index" class="layui-this">基本配置</li>
                    <li data-type="collection" data-url="/collection/find/" lay-id="collection">邮箱配置</li>
                </ul>

                    <div class="layui-tab-content" style="padding: 20px 0;">
                        <div class="layui-tab-item layui-show">
                            <form class="layui-form" action="/user/setsite/1" method="post">
                                {{csrf_field()}}
                                <div class="layui-form-item">
                                    <label class="layui-form-label">网站标题</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="site_name" placeholder="请输入" autocomplete="off" class="layui-input" value="{{$site->site_name or ''}}">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">SEO标题</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="seo" placeholder="请输入" autocomplete="off" class="layui-input" value="{{$site->seo or ''}}">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">SEO关键字</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="seo_key" placeholder="请输入" autocomplete="off" class="layui-input" value="{{$site->seo_key or ''}}">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">编辑器</label>
                                    <div class="layui-input-block">
                                        <input type="radio" name="uedit" value="1" title="uedit" @if(isset($site) && $site->uedit == 1) checked @endif>
                                        <input type="radio" name="uedit" value="0" title="markdown" @if(isset($site) && $site->uedit == 0) checked @endif>
                                        <input type="radio" name="uedit" value="2" title="wangEditor" @if(isset($site) && $site->uedit == 2) checked @endif>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">会员注册</label>
                                    <div class="layui-input-block">
                                        <input type="radio" name="user_reg" value="1" title="开启" @if(isset($site) && $site->user_reg == 1) checked @endif>
                                        <input type="radio" name="user_reg" value="0" title="关闭" @if(isset($site) && $site->user_reg == 0) checked @endif>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">允许发帖</label>
                                    <div class="layui-input-block">
                                        <input type="radio" name="forum_sh" value="1" title="开启" @if(isset($site) && $site->forum_sh == 1) checked @endif>
                                        <input type="radio" name="forum_sh" value="0" title="关闭" @if(isset($site) && $site->forum_sh == 0) checked @endif>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">邮箱验证</label>
                                    <div class="layui-input-block">
                                        <input type="radio" name="email_sh" value="1" title="开启" @if(isset($site) && $site->email_sh == 1) checked @endif>
                                        <input type="radio" name="email_sh" value="0" title="关闭" @if(isset($site) && $site->email_sh == 0) checked @endif>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">版权信息</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="site_copyright" placeholder="请输入" autocomplete="off" class="layui-input" value="{{$site->site_copyright or ''}}">
                                    </div>
                                </div>
                                {{--<div class="layui-form-item">--}}
                                    {{--<label class="layui-form-label">ICP备案号</label>--}}
                                    {{--<div class="layui-input-block">--}}
                                        {{--<input type="text" name="site_icp" placeholder="请输入" autocomplete="off" class="layui-input" value="{{$site->site_icp or ''}}">--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                <div class="layui-form-item layui-form-text">
                                    <label class="layui-form-label">统计代码</label>
                                    <div class="layui-input-block">
                                        <textarea placeholder="请输入内容" name="site_tongji" class="layui-textarea">{{$site->site_tongji or ''}}</textarea>
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

                        <div class="layui-tab-item">
                            <form class="layui-form" action="/user/setsite/2" method="post">
                                {{csrf_field()}}
                                <div class="layui-form-item">
                                    <label class="layui-form-label">SMTP服务器</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="smtp_host" placeholder="请输入" autocomplete="off" class="layui-input" value="{{$site->smtp_host or ''}}" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">SMTP端口号</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="smtp_port" placeholder="请输入" autocomplete="off" class="layui-input" value="{{$site->smtp_port or ''}}">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">SMTP用户名</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="smtp_name" placeholder="请输入" autocomplete="off" class="layui-input" value="{{$site->smtp_name or ''}}">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">SMTP密码</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="smtp_password" placeholder="请输入" autocomplete="off" class="layui-input" value="{{$site->smtp_password or ''}}">
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
