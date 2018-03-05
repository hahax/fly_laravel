基于Layui社区、laravel5.4开发的简易社区系统
已集成功能：七牛云存储,阿里oss上传,腾讯云cos上传,大文件分片上传,markdown编辑器,
基于spatie/laravel-backup的文件、数据库备份功能
#安装步骤

###1.配置env
配置数据库，缓存等

###2.安装数据表
php artisan migrate 

###3.管理员数据填充
php artisan db:seed

```
安装后默认管理账号：admin@admin.com  密码:123456

如果需要修改，请在填充前修改database/seeds/DatabaseSeeder.php
```

###4.关于编辑器
1.markdown(https://laravel-china.org/topics/853/laravel5-markdown-editor-tutorial)
2.uedit
3.wangEditor(https://www.kancloud.cn/wangfupeng/wangeditor3/332599)

###5.分页备份
```
@if($paginator->hasPages())
    @if ($paginator->onFirstPage())
        {{--<span>&laquo;</span>--}}
    @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev">上一页</a>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="laypage-curr">{{ $element }}</span>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="laypage-curr">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next">下一页</a>
    @else
        {{--<span>&raquo;</span>--}}
    @endif
@endif
```

###6.使用扩展包
`AetherUpload`
`Entrust`
`qiniu` => `composer require zgldh/qiniu-laravel-storage`
`spatie/laravel-backup` => `composer require "spatie/laravel-backup"`