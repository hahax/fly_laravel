<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>{{$site->site_name  or ''}}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="keywords" content="{{$site->seo or ''}}">
  <meta name="description" content="{{$site->seo_key or ''}}">
  <link rel="stylesheet" href="/layui/css/layui.css">
  <link rel="stylesheet" href="/css/global.css">
  <link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="childrenBody fly-full">

@include('layouts.header')

@yield('content')

@include('layouts.footer')

@yield('js')
</body>
</html>