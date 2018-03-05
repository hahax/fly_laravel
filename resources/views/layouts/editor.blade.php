@if($site->uedit == 0)
    <div class="editor">
        <textarea id='myEditor' name="content" required placeholder="详细描述" lay-verify="required">{{ old('content') }}</textarea>
    </div>
    @include('layouts.markdown')
    @elseif($site->uedit == 1)
        @include('vendor.UEditor.head')
        <!-- 加载编辑器的容器 -->
        <script id="container" name="content" type="text/plain" style='width:100%;height:300px;'>
            {!! old('content') !!}
            {{--{!! html_entity_decode(old('content')) !!}--}}
        </script>
        <!-- 实例化编辑器 -->
        <script type="text/javascript">
        var ue = UE.getEditor('container');
        ue.ready(function(){
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });
        </script>
    @elseif($site->uedit == 2)
        {!! we_css() !!}
        {!! we_js() !!}
        {!! we_field('wangeditor', 'content', '') !!}
        {!! we_config('wangeditor') !!}
@endif
<style>
    dl.layui-anim.layui-anim-upbit {
        z-index: 1001;
    }
</style>
