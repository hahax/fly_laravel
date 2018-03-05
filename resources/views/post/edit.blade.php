
@extends('layouts.main')

@section('content')
<div class="layui-container fly-marginTop">
  <div class="fly-panel" pad20 style="padding-top: 5px;">
    <!--<div class="fly-none">没有权限</div>-->
    <div class="layui-form layui-form-pane">
      <div class="layui-tab layui-tab-brief" lay-filter="user">
        <ul class="layui-tab-title">
          <li class="layui-this">编辑帖子</li>
        </ul>
        <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
          <div class="layui-tab-item layui-show">
            <form action="/posts/{{$post->id}}" method="POST">
              {{method_field('PUT')}}
              {{ csrf_field() }}
              <div class="layui-row layui-col-space15 layui-form-item">
                <div class="layui-col-md3">
                  <label class="layui-form-label">所在专栏</label>
                  <div class="layui-input-block">
                    <select lay-verify="required" name="menus" lay-filter="column">
                      <option value="{{$post->cate->id}}" class="layui-this">{{$post->cate->cate_name}}</option>
                      @foreach($menus as $menu)
                        @if($menu->id !== $post->menus)
                        <option value="{{$menu->id}}">{{$menu->cate_name}}</option>
                        @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="layui-col-md9">
                  <label for="L_title" class="layui-form-label">标题</label>
                  <div class="layui-input-block">
                    <input type="text" id="L_title" name="title" required lay-verify="required" autocomplete="off" class="layui-input" value="{{ $post->title }}">
                  </div>
                </div>
              </div>
              <div class="layui-row layui-col-space15 layui-form-item layui-hide" id="LAY_quiz">
                <div class="layui-col-md3">
                  <label class="layui-form-label">所属产品</label>
                  <div class="layui-input-block">
                    <select name="project">
                      <option></option>
                      <option value="layui">layui</option>
                      <option value="独立版layer">独立版layer</option>
                      <option value="独立版layDate">独立版layDate</option>
                      <option value="LayIM">LayIM</option>
                      <option value="Fly社区模板">Fly社区模板</option>
                    </select>
                  </div>
                </div>
                <div class="layui-col-md3">
                  <label class="layui-form-label" for="L_version">版本号</label>
                  <div class="layui-input-block">
                    <input type="text" id="L_version" value="" name="version" autocomplete="off" class="layui-input">
                  </div>
                </div>
                <div class="layui-col-md6">
                  <label class="layui-form-label" for="L_browser">浏览器</label>
                  <div class="layui-input-block">
                    <input type="text" id="L_browser"  value="" name="browser" placeholder="浏览器名称及版本，如：IE 11" autocomplete="off" class="layui-input">
                  </div>
                </div>
              </div>
              <div class="layui-form-item layui-form-text">
                @if($site->uedit == 0)
                  <div class="editor">
                    <textarea id='myEditor' name="content" required placeholder="详细描述" lay-verify="required">{{ $post->content }}</textarea>
                  </div>
                  @include('layouts.markdown')
                  @elseif($site->uedit == 1)
                    @include('vendor.UEditor.head')
                    <!-- 加载编辑器的容器 -->
                    <script id="container" name="content" type="text/plain" style='width:100%;height:300px;'>
                      {!! html_entity_decode($post->content) !!}
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
                    {!! we_field('wangeditor', 'content', $post->content) !!}
                    {!! we_config('wangeditor') !!}
                @endif
              </div>
              @include('layouts.error')
              <div class="layui-form-item">
                {{--  <button class="layui-btn" type="submit" lay-filter="*" lay-submit>立即发布</button>  --}}
                <button class="layui-btn" type="submit">立即发布</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
  @include("layouts.js")
@endsection
