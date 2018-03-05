@extends('layouts.main')

@section('content')
    <div class="layui-container fly-marginTop fly-user-main">
        @include('layouts.umenu')
        <div class="fly-panel fly-panel-user" pad20>
            <div style="margin-bottom: 5px;"></div>

            <div class="layui-btn-group demoTable">
                <a class="layui-btn" style="color:#FFFFFF" href="/user/createCate"><i class="layui-icon">&#xe608;</i>新建板块</a>
                {{--<button class="layui-btn" data-type="getCheckData">获取选中行数据</button>--}}
                {{--<button class="layui-btn" data-type="getCheckLength">获取选中数目</button>--}}
                {{--<button class="layui-btn" data-type="isAll">验证是否全选</button>--}}
            </div>
            <table class="layui-table" lay-data="{width: 892,  url:'/user/getCate', page:true, id:'idTest'}" lay-filter="demo">
                <thead>
                <tr>
                    <th lay-data="{type:'checkbox', fixed: 'left', align:'center'}"></th>
                    <th lay-data="{field:'id', width:60, sort: true, fixed: true, align:'center'}">ID</th>
                    <th lay-data="{field:'cate_order', width:80, sort: true, fixed: true, align:'center'}">排序</th>
                    <th lay-data="{field:'cate_name', sort: true, align:'center',event:'cate_name', style:'cursor: pointer;'}">板块名称</th>
                    <th lay-data="{field:'cate_key', width:120, sort: true, align:'center'}">栏目关键字</th>
                    <th lay-data="{field:'description', width:100, align:'center'}">栏目描述</th>
                    <th lay-data="{fixed: 'right',width:180, align:'center', toolbar: '#barDemo'}">基本操作</th>
                </tr>
                </thead>
            </table>

            <script type="text/html" id="barDemo">
                {{-- <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail">查看</a> --}}
                <a class="layui-btn layui-btn-xs" lay-event="cate_name">编辑</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
            </script>

            <script src="/layui/layui.js" charset="utf-8"></script>
            <script src="/js/jquery.min.js"></script>
            <!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
            <script>
                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
                });
                layui.use('table', function(){
                    var table = layui.table,form = layui.form;

                    //监听表格复选框选择
                    table.on('checkbox(demo)', function(obj){
                        console.log(obj)
                    });
                    //监听工具条
                    table.on('tool(demo)', function(obj){
                        var data = obj.data;
                        if(obj.event === 'cate_name'){
                            layer.prompt({
                                // formType: 2,
                                title: '修改 栏目  ['+ data.cate_name +'] 的名称',
                                value: data.cate_name
                            }, function(value, index){
                                layer.close(index);
                                //这里一般是发送修改的Ajax请求
                                var url="/user/editCateAjax/"+data.id+"/1";
                                $.ajax({
                                    url : url,
                                    type : "post",
                                    dataType : "json",
                                    data: {id:data.id,cate_name:value},
                                    success : function(res) {
                                        if(res.code==200) {
                                            obj.update({
                                                cate_name: value
                                            });
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
                        }
                        if(obj.event === 'detail'){
                            layer.msg('ID：'+ data.id + ' 的查看操作');
                        } else if(obj.event === 'del'){
                            layer.confirm('真的删除此栏目么？', function(index){
                                obj.del();
                                layer.close(index);
                                var url="/user/editCateAjax/"+data.id+"/2";
                                $.ajax({
                                    url : url,
                                    type : "post",
                                    dataType : "json",
                                    data: {id:data.id},
                                    success : function(res) {
                                        if(res.code==200) {
                                            obj.del();
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
                        } else if(obj.event === 'edit'){
                            layer.alert('编辑行：<br>'+ JSON.stringify(data))
                        }
                    });

                    var $ = layui.$, active = {
                        getCheckData: function(){ //获取选中数据
                            var checkStatus = table.checkStatus('idTest')
                                ,data = checkStatus.data;
                            layer.alert(JSON.stringify(data));
                        }
                        ,getCheckLength: function(){ //获取选中数目
                            var checkStatus = table.checkStatus('idTest')
                                ,data = checkStatus.data;
                            layer.msg('选中了：'+ data.length + ' 个');
                        }
                        ,isAll: function(){ //验证是否全选
                            var checkStatus = table.checkStatus('idTest');
                            layer.msg(checkStatus.isAll ? '全选': '未全选')
                        }
                    };

                    $('.demoTable .layui-btn').on('click', function(){
                        var type = $(this).data('type');
                        active[type] ? active[type].call(this) : '';
                    });
                });
            </script>
        </div>
    </div>
@endsection