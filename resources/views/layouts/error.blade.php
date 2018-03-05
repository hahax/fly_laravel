@if(count($errors)>0)
<blockquote class="layui-elem-quote">
    @foreach($errors->all() as $error)
        {{ $error }}<br/>
    @endforeach
</blockquote>
@endif