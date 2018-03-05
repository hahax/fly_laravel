@extends('layouts.main')

@section('content')
    <div class="layui-container fly-marginTop fly-user-main">
        @include('layouts.umenu')
        <div class="fly-panel fly-panel-user" pad20>
            <div style="margin-bottom: 5px;"></div>
            <div class="layui-btn-group demoTable">
                <a class="layui-btn" style="color:#FFFFFF" id="newLink" href="/user/case/createCase"><i class="layui-icon">&#xe608;</i>新建案例</a>
            </div>
            <div class="layui-tab layui-tab-brief" lay-filter="user">
                <table class="layui-table" lay-size="lg" lay-filter="link">
                    <colgroup>
                        <col width="50">
                        <col width="100">
                        <col>
                        <col>
                        <col>
                        <col width="280">
                    </colgroup>
                    <thead>
                    <tr>
                        <th lay-data="{sort: true}">排序</th>
                        <th lay-data="{sort: true, edit: 'text'}">名称</th>
                        <th lay-data="{sort: true, edit: 'text'}">git地址</th>
                        <th lay-data="{sort: true, edit: 'text'}">网站地址</th>
                        <th lay-data="{sort: true, edit: 'text'}">案例图片</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cases as $case)
                        <tr>
                            <td >{{$case->case_sort}}</td>
                            <td >{{str_limit($case->title,10)}}</td>
                            <td >{{str_limit($case->git_path,20)}}</td>
                            <td >{{str_limit($case->http_path,20)}}</td>
                            <td ><img src="{{$case->pic_path or '/uploads/default.jpg'}}" style="width: 80px;height: 80px"></td>
                            <td>
                                <div class="layui-btn-group">
                                    <a href="/user/case/editCase/{{$case->id}}">
                                        <button class="layui-btn layui-btn-sm">
                                            <i class="layui-icon">&#xe642;</i>编辑
                                        </button>
                                    </a>
                                    <a href="/user/case/deleteCase/{{$case->id}}" style="margin-left: 10px">
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
                        {{$cases->links()}}
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
@section('js')
    @include("layouts.js")
@endsection

