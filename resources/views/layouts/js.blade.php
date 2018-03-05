<script src="/layui/layui.js"></script>
<script src="/js/jquery.min.js"></script>
@include('myflash::notification')
<script>
    layui.config({
        version: "3.0.0"
        , base: '/mods/' //这里实际使用时，建议改成绝对路径
    }).extend({
        fly: 'index'
    }).use('fly');
</script>
