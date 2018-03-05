@extends('layouts.main')

@section('content')
    <style>
        #Images li {
            width: 19%;
            margin: 0.5% 0.5%;
            /*float: left;*/
            overflow: hidden;
            display: inline-block;
        }
        #Images li img {
            width: 100%;
            cursor: pointer;
            height: 150px;
        }
        #Images li .operate {
            display: block;
            height: 40px;
            width: 100%;
            background: #f4f5f9;
        }
        #Images li .operate .check {
            float: left;
            margin-left: 11px;
            height: 18px;
            padding: 11px 0;
            width: 74%;
            position: relative;
        }
        #Images li .operate .img_del {
            float: right;
            margin: 13px 11px 0 0;
            font-size: 20px !important;
            cursor: pointer;
        }
        #Images li .operate .check .layui-form-checkbox[lay-skin=primary] {
            width: 100%;
        }
        #Images li .operate .check .layui-form-checkbox[lay-skin=primary] span {
            padding: 0 5px 0 25px;
            width: 100%;
            box-sizing: border-box;
        }
        #Images li .operate .check .layui-form-checkbox[lay-skin=primary] i {
            position: absolute;
            left: 0;
            top: 0;
        }
    </style>
    <div class="layui-container fly-marginTop fly-user-main">
        @include('layouts.umenu')
        <div class="fly-panel fly-panel-user" pad20>
            <div class="layui-tab layui-tab-brief" lay-filter="user">
                <ul class="layui-tab-title" id="LAY_mine">
                    <a href="/user/setfile"><li>附件管理</li></a>
                    <a href="/user/setfile/pic"><li>图片上传</li></a>
                    <a href="/user/setfile/editpic"><li>图片管理</li></a>
                    <a href="/user/setfile/aethupload"><li>大附件上传</li></a>
                    <a href="/user/setfile/videos"><li>视频管理</li></a>
                    <a href="/user/setfile/videoList"><li class="layui-this">视频列表</li></a>
                </ul>
                <div class="layui-tab-content" style="padding: 20px 0;">
                    <div class="layui-form layui-form-pane layui-tab-item layui-show">
                        <ul class="layer-photos-demo" id="Images"></ul>
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

        layui.use(['flow','form','layer','upload'],function(){
            var flow = layui.flow,
                form = layui.form,
                layer = parent.layer === undefined ? layui.layer : top.layer,
                upload = layui.upload,
                $ = layui.jquery;

            //流加载图片
            var imgNums = 15;  //单页显示图片数量

            flow.load({
                elem: '#Images', //流加载容器
                done: function(page, next){ //加载下一页
                    $.get("/user/videoJson",function(res){
                        //模拟插入
                        var imgList = [],data = res.data;
                        var maxPage = imgNums*page < data.length ? imgNums*page : data.length;
                        setTimeout(function(){
                            for(var i=imgNums*(page-1); i<maxPage; i++){
                                imgList.push('<li class="photos">' +
                                    '<video width="173.84" height="150" controls ><source src="'+data[i].src+'" type="video/mp4"></video></li>');
                            }
                            next(imgList.join(''), page < (data.length/imgNums));
                            form.render();
                        }, 500);
                    });
                }
            });

            //设置图片的高度
            // $(window).resize(function(){
            //     $("#Images li img").height($("#Images li img").width());
            // })

            //多图片上传
            upload.render({
                elem: '.uploadNewImg',
                url: '/user/uploadPic',
                multiple: true,
                before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#Images').prepend('<li><img layer-src="'+ result +'" src="'+ result +'" alt="'+ file.name +'" class="layui-upload-img"><div class="operate"><div class="check"><input type="checkbox" name="belle" lay-filter="choose" lay-skin="primary" title="'+file.name+'"></div><i class="layui-icon img_del">&#xe640;</i></div></li>')
                        //设置图片的高度
                        $("#Images li img").height($("#Images li img").width());
                        form.render("checkbox");
                    });
                },
                done: function(res){
                    //上传完毕
                }
            });

            //弹出层
            $("body").on("click","#Images img",function(){
                parent.showImg();
            })


            //删除单张图片
            $("body").on("click",".img_del",function(){
                var _this = $(this);
                var id = _this.siblings().find("input").attr("title");
                layer.confirm('确定删除图片"'+_this.siblings().find("input").attr("title")+'"吗？',{icon:3, title:'提示信息'},function(index){
                    var url="/user/delPic";
                    $.ajax({
                        url : url,
                        type : "post",
                        dataType : "json",
                        data: {'id':id},
                        success : function(res) {
                            if(res.code==200) {
                                layer.msg(res.msg);
                                _this.parents("li").hide(1000);
                                setTimeout(function(){_this.parents("li").remove();},950);
                                layer.close(index);
                            } else {
                                layer.alert("出错了！！请检查后重试",{title:'错误提示',icon:0});
                            }
                        },
                        error:function (msg) {
                            layer.alert("出错了！！请检查后重试",{title:'错误提示',icon:0});
                        },
                    });
                });
            })

            //全选
            form.on('checkbox(selectAll)', function(data){
                var child = $("#Images li input[type='checkbox']");
                child.each(function(index, item){
                    item.checked = data.elem.checked;
                });
                form.render('checkbox');
            });

            //通过判断是否全部选中来确定全选按钮是否选中
            form.on("checkbox(choose)",function(data){
                var child = $(data.elem).parents('#Images').find('li input[type="checkbox"]');
                var childChecked = $(data.elem).parents('#Images').find('li input[type="checkbox"]:checked');
                if(childChecked.length == child.length){
                    $(data.elem).parents('#Images').siblings("blockquote").find('input#selectAll').get(0).checked = true;
                }else{
                    $(data.elem).parents('#Images').siblings("blockquote").find('input#selectAll').get(0).checked = false;
                }
                form.render('checkbox');
            })

            //批量删除
            $(".batchDel").click(function(){
                var $checkbox = $('#Images li input[type="checkbox"]');
                var $checked = $('#Images li input[type="checkbox"]:checked');
                if($checkbox.is(":checked")){
                    layer.confirm('确定删除选中的图片？',{icon:3, title:'提示信息'},function(index){
                        var index = layer.msg('删除中，请稍候',{icon: 16,time:false,shade:0.8});
                        setTimeout(function(){
                            //删除数据
                            $checked.each(function(){
                                $(this).parents("li").hide(1000);
                                setTimeout(function(){$(this).parents("li").remove();},950);
                            })
                            $('#Images li input[type="checkbox"],#selectAll').prop("checked",false);
                            form.render();
                            layer.close(index);
                            layer.msg("删除成功");
                        },2000);
                    })
                }else{
                    layer.msg("请选择需要删除的图片");
                }
            })

        })

        //图片管理弹窗
        function showImg(){
            $.getJSON('/user/piclists', function(json){
                let res = json;
                layer.photos({
                    photos: res,
                    anim: 5
                });
            });
        }
    </script>
@endsection
