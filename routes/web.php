<?php
// 管理模块
Route::group(['middleware'=>['admin.menu','auth']],function (){
//  Excel
    Route::get('excel/export','ExcelController@export');
    Route::get('excel/import','ExcelController@import');
//  友情链接
    Route::get('/user/setlink','UserController@setLink');

    Route::get('/user/createLink','UserController@createLink');
    Route::post('/user/createLink','UserController@doCreateLink');
    Route::post('/user/editLink','UserController@doEditLink');
    Route::get('/user/editLink/{friendLink}','UserController@editLink');
    Route::post('/user/doEditLink/{friendLink}','UserController@doEdit');
    Route::get('/user/deleteLink/{friendLink}','UserController@doDelLink');
//  社区板块
    Route::get('/user/setcate','UserController@setCate');
    Route::get('/user/getCate','UserController@getCate');
    Route::get('/user/createCate','UserController@createCate');
    Route::post('/user/createCate','UserController@createStore');
    Route::post('/user/editCateAjax/{cate}/{type}','UserController@editStoreAjax');
//  网站设置
    Route::get('/user/setsite','UserController@setSite');
    Route::post('/user/setsite/{type}','UserController@siteStore');
// 置顶
    Route::get('posts/top/{post}/{type}','PostController@doTop');
// 精华
    Route::get('posts/rsuv/{post}/{type}','PostController@doRsuv');
// 上传附件
    Route::get('/user/setfile','UserController@setFile');
//  下载附件
    Route::any('/user/downfile/{file_list}','UserController@downFile');
    Route::get('/user/delFile/{file_list}','UserController@delFile');
    Route::get('/user/setfile/pic','UserController@setPic');
    Route::post('/user/uploadFile','UserController@uploadFile');
//  视频
    Route::get('/user/setfile/videos','UserController@videos');
    Route::get('/user/setfile/videoList','UserController@videoList');
    Route::get('/user/downVideo/{video_list}','UserController@downVideo');
    Route::get('/user/delVideo/{video_list}','UserController@delVideo');
    Route::get('/user/setfile/videoList','UserController@videoList');
    Route::get('/user/videoJson','UserController@videoListJson');
    Route::get('/user/clearAeth','UserController@clearAeth');
//  上传视频
    Route::post('/user/uploadVideo','UserController@uploadVideo');
    Route::post('/user/uploadPic','UserController@uploadPic');
    Route::post('/user/uploadPicQiniu','UserController@uploadPicQiniu');
    Route::get('/user/setfile/editpic','UserController@editPic');
    Route::get('/user/piclists','UserController@picRet');
    Route::post('/user/delPic','UserController@delPic');
//  案例
    Route::get('/user/case','UserController@caseIndex');
    Route::get('/user/case/createCase','UserController@createCase');
    Route::get('/user/case/editCase/{cases}','UserController@editCase');
    Route::post('/user/editCase/{cases}','UserController@editCaseStore');
    Route::post('/user/createCase','UserController@createCaseStore');
//  大文件上传
    Route::get('/user/setfile/aethupload','UserController@aethUpload')->name('aeth');
//  大文件下载
    Route::get('/user/downaeth/{aether}','UserController@downAeth');
    Route::get('/user/delaeth/{aether}','UserController@delAeth');
    Route::post('/user/setfile/aethupload','UserController@aethUploadStore');
//  下载页面md
    Route::get('/posts/{post}/downMd','UserController@downMd');
//  测试
    Route::any('/user/test','UserController@test');
});

Route::group(['middleware'=>'auth'],function (){
// 个人设置页面
    Route::get('/user/setting','UserController@setting');
    Route::get('/user/setting/avatar','UserController@settingAva');
    Route::get('/user/setting/pass','UserController@settingPass');

// 修改密码
    Route::post('/user/repass/{user}','UserController@repass');
// 个人设置操作
    Route::post('/user/me/setting','UserController@settingStore');
// 用户中心
    Route::get('/user/index/{user}','UserController@index');
    Route::get('/user/index/coll/{user}','UserController@indexColl');
// 我的消息
    Route::get('/user/message','UserController@message');
// 激活邮箱
    Route::get('/user/activate','UserController@activate');
// 修改个人设置
    Route::post('/user/dosetting','UserController@doSetting');
// ajax上传图片
    Route::post('/user/uploadImg','UserController@uploadImg');
// 创建文章
    Route::get('/posts/create','PostController@create');
    Route::post('/posts','PostController@store');
// 编辑文章
    Route::get('/posts/{post}/edit','PostController@edit');
    Route::put('/posts/{post}','PostController@update');
// 删除文章
    Route::get('posts/{post}/delete','PostController@destroy');
    Route::get('posts/{comment}/deleteComment','PostController@destroyComment');
// 图片上传
    Route::post('/posts/image/upload', 'PostController@imageUpload');
    Route::post('/post/uploadImg', 'PostController@upload');
// 发表回复
    Route::post('/posts/comment','PostController@comment');
//收藏帖子
    Route::get('/posts/collection/{post}','PostController@doColl');
//    取消收藏
    Route::get('/posts/collection/qxcol/{post}','PostController@doQxColl');
});
// 个人中心首页
Route::get('/user/home/{user}','UserController@home');
// 用户模块
// 注册页面
Route::get('/register', 'RegisterController@index');
// 注册行为
Route::post('/register', 'RegisterController@register');
// 登陆页面
Route::get('/login', 'LoginController@index');
// 登陆行为
Route::post('/login', 'LoginController@login');
// 登出行为
Route::get('/logout', 'LoginController@logout');

Route::get('/','PostController@index');
// 文章列表
Route::get('/posts','PostController@index');

Route::get('/posts/index/{cate}','PostController@postIndex');
// 文章详情
Route::get('/posts/show/{post}','PostController@show');
// 案例
Route::get('/case/case','CaseController@index');
// 验证码图片
Route::get('pic/cap/{tmp}','LoginController@captcha');
// 视频
Route::get('/videoList','ExcelController@video');


