<?php

namespace App\Http\Controllers;

use App\Aether;
use App\Cases;
use App\Cate;
use App\FileList;
use App\FriendLink;
use App\PicList;
use App\Post;
use App\Services\OSS;
use App\SiteConfig;
use App\VideoList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Qiniu\Auth;
use zgldh\QiniuStorage\QiniuStorage;

class UserController extends Controller
{
    public function caseIndex()
    {
        $cases = Cases::orderBy('case_sort')->paginate(5);
        return view('user.case',compact('cases'));
    }

    public function createCase()
    {
        return view('user.createCase');
    }

    public function editCase(Cases $cases)
    {
        return view('user.editCase',compact('cases'));
    }

    public function editCaseStore(Request $request,Cases $cases)
    {
        $this->validate(request(),[
            'title' => 'required',
            'content' => 'required',
        ]);
        $cases->update(request(['title','content','pic_path','git_path','http_path','case_sort']));
        return redirect('/user/case');
    }

    public function createCaseStore(Request $request)
    {
        $this->validate(request(),[
            'title' => 'required',
        ]);
        $params = array_merge(request(['title','content','pic_path','git_path','http_path','case_sort']));
        Cases::create($params);
        return redirect('/user/case');
    }

    public function setFile()
    {
        $files = FileList::orderBy("created_at","desc")->paginate(10);
        return view('user.setfile',compact('files'));
    }

    public function downFile(FileList $fileList)
    {
        return response()->download(public_path().$fileList->path,urldecode($fileList->file_name));
    }

    public function downAeth(Aether $aether)
    {
//        return response()->download(public_path().$aether->path,urldecode($aether->name));
        if($aether->type == 1)
        {
            $path = $aether->path;
        }elseif($aether->type == 0)
        {
            $path = public_path().$aether->path;
        }
        if (file_exists($path)){
            $file = fopen($path,"r");
            Header("Content-type: application/octet-stream");
            Header("Accept-Ranges: bytes");
            Header("Accept-Length: ".filesize($path));
            Header("Content-Disposition: attachment; filename=".urldecode($aether->name));
            echo fread($file, filesize($path));
            $buffer=512;
            $file_count=0;

            while(!feof($file) && $file_count<filesize($path)){
                $file_con=fread($file,$buffer);
                $file_count+=$buffer;
                echo ($file_con);
            }

            fclose($file);
        }else {
            return back()->withErrors("下载文件不存在");
        }
    }

    public function downVideo(VideoList $videoList)
    {
//        return response()->download(public_path().$videoList->path,urldecode($videoList->name));
        $path = public_path().$videoList->path;
        if (file_exists($path)){
            //打开文件
            $file = fopen($path,"r");
            //返回的文件类型
            Header("Content-type: application/octet-stream");
            //按照字节大小返回
            Header("Accept-Ranges: bytes");
            //返回文件的大小
            Header("Accept-Length: ".filesize($path));
            //这里对客户端的弹出对话框，对应的文件名
            Header("Content-Disposition: attachment; filename=".urldecode($videoList->name));
            //修改之前，一次性将数据传输给客户端
            echo fread($file, filesize($path));
            //修改之后，一次只传输1024个字节的数据给客户端
            //向客户端回送数据
            $buffer=1024;//
            //判断文件是否读完
            while (!feof($file)) {
                //将文件读入内存
                $file_data=fread($file,$buffer);
                //每次向客户端回送1024个字节的数据
                echo $file_data;
            }
            fclose($file);
        }else {
            return back()->withErrors("下载文件不存在");
        }
    }

    public function setPic()
    {
        return view('user.setPic');
    }

    public function repass(Request $request,User $user)
    {
        $this->validate(request(),[
            'nowpass' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
        if(Hash::check(request('nowpass'),$user->password))
        {
            if($user->password == bcrypt(request('password')))
            {
                return back()->withErrors("密码无变化");
            }
            $user->password = bcrypt(request('password'));
            $user->save();
            \Auth::logout();
            return redirect('/login');
        }else
        {
            return back()->withErrors("原密码错误");
        }

    }

    public function doDelLink(FriendLink $friendLink)
    {
        $friendLink->delete();
        return redirect('/user/setlink');
    }

    public function doEdit(Request $request,FriendLink $friendLink)
    {
//        dd($request->all());
        $this->validate(request(),[
            'sort' => 'required|integer',
            'name' => 'required',
            'link' => 'required',
        ]);
        if(isset($request->is_show) && $request->is_show == 'on')
        {
            $is_show = 1;
        }else
        {
            $is_show = 0;
        }
        $friendLink->update(array_merge(request(['sort','name','link']),['is_show'=>$is_show]));
        return redirect('/user/setlink');
    }

    public function doEditLink(Request $request)
    {
        if(\Request::ajax())
        {
            $type = $request->type;
            $link = FriendLink::find($request->id);
            $link[$type] = $request->data;
            $link->save();
            $data['code'] = 200;
            $data['msg'] = "修改成功";
            return $data;
        }
    }

    public function editLink(FriendLink $friendLink)
    {
        return view('user.editlink',compact('friendLink'));
    }

    public function createLink()
    {
        return view('user.createLink');
    }

    public function doCreateLink(Request $request)
    {
        $this->validate(request(),[
            "sort" => "required|integer",
            "name" => "required",
            "link" => "required",
        ]);
        if(isset($request->is_show) && $request->is_show=='on')
        {
            $is_show = 1;
        }else
        {
            $is_show = 0;
        }
        $params = array_merge(request(['sort','name','link']),['is_show'=>$is_show]);
        FriendLink::create($params);
        return redirect('/user/setlink');
    }

    public function setCate()
    {
        return view('user.setcate');
    }

    public function getCate()
    {
        $cates = Cate::orderBy("cate_order")->get();
        $cate['code'] = 0;
        $cate['msg'] = "";
        $cate['data'] = $cates;
        $cate['count'] = count($cate['data']);
        return $cate;
    }

    public function editStoreAjax(Request $request,Cate $cate,$type)
    {
        if($type=='1')
        {
            $this->validate(\request(),[
                "cate_name" => "required|min:2",
            ]);
            $cate->update(request(['cate_name']));
            $data['code'] = 200;
            $data['msg'] = "修改成功";
        }elseif ($type=='2')
        {
            $cate->delete();
            $data['code'] = 200;
            $data['msg'] = "删除成功";
        }
        return $data;
    }

    public function createCate()
    {
        return view('user.createCate');
    }

    public function createStore(Request $request)
    {
        $this->validate(\request(),[
            "cate_order" => "required|integer",
            "cate_name" => "required",
        ]);
        $params = array_merge(request(["cate_order","cate_name","cate_key","description"]));
        Cate::create($params);
        return redirect('/user/setcate');
    }

    public function setLink()
    {
        $links = FriendLink::orderBy("sort")->paginate(10);
        return view('user.setlink',compact('links'));
    }

    public function setSite()
    {
        $site = SiteConfig::first();
        return view('user.setsite',compact('site'));
    }

    public function siteStore(Request $request,$type)
    {
        $this->validate(request(),[
            'user_reg' => 'boolean',
            'forum_sh' => 'boolean',
            'email_sh' => 'boolean'
        ]);
        if($type==1)
        {
            $params = array_merge(request([
                'site_name','seo','seo_key','user_reg','forum_sh','email_sh','site_copyright','site_icp','site_tongji','uedit'
            ]));
        }
        if($type==2)
        {
            $params = array_merge(request([
                'smtp_host','smtp_port','smtp_name','smtp_password'
            ]));
        }

        $is_use = SiteConfig::first();
        if($is_use)
        {
            $is_use->update($params);
        }else
        {
            \App\SiteConfig::create($params);
        }
        return back();
    }

    public function setting()
    {
        return view('user.setting');
    }

    public function settingAva()
    {
        return view('user.avatar');
    }

    public function settingPass()
    {
        return view('user.pass');
    }

    public function settingStore()
    {

    }

    public function index(User $user)
    {
        $posts = $user->posts()->orderBy('created_at','desc')->paginate(11);
        $num = \App\User::withCount(['posts'])->find($user->id);
        $collNum = \App\User::withCount('collection')->find($user->id);
        return view('user.index',compact('posts','num','collNum'));
    }

    public function indexColl(User $user)
    {
        $num = \App\User::withCount(['posts'])->find($user->id);
        $colls = $user->collection()->orderBy('created_at','desc')->paginate(11);
        $collNum = \App\User::withCount('collection')->find($user->id);
        return view('user.indexColl',compact('num','collNum','colls'));
    }

    public function home(User $user)
    {
        $posts = $user->posts()->withCount("comments")->orderBy('created_at','desc')->take(15)->get();
        $comments = $user->comments()->take(5)->get();
        return view('user.home',compact('user','posts','comments'));
    }

    public function message()
    {
        return view('user.message');
    }

    public function activate()
    {
        return view('user.activate');
    }

    public function doSetting(Request $request)
    {
        $uid = \Auth::user();
        $user = \App\User::find($uid->id);
        $name = request('name');
        if($name !== $user->name)
        {
            if(\App\User::where('name',$name)->count()>0)
            {
                return back()->withErrors('昵称已存在');
            }
            $user->name = $name;
        }
        $user->gender = request('gender');
        $user->autograph = request('autograph');
        $user->save();
        return redirect('/user/setting');
    }

    public function uploadImg(Request $request)
    {
        if ($request->ajax() && \Auth::check()) {
            $user = \Auth::user();
            // dd($request->file('file'));
            $file = $request->file('file');
            // 第一个参数代表目录, 第二个参数代表我上方自己定义的一个存储媒介
            $path = '/uploads/'.$file->store('avatars', 'uploads');
            $user->avatar = $path;
            $user->save();
            return response()->json(array('path' => $path));
        }
        // 注意看下方模版代码
        return view('user/setting');
    }

    public function uploadFile(Request $request)
    {
        if ($request->ajax() && \Auth::check()) {
            $user = \Auth::user();
            // dd($request->file('file'));
            $file = $request->file('file');
            // 第一个参数代表目录, 第二个参数代表我上方自己定义的一个存储媒介
            $path = '/uploads/'.$file->storeAs('files', urlencode($file->getClientOriginalName()),'uploads');
            $params = array_merge([
                'disk' => 'local',
                'path' => $path,
                'ip'   => $request->ip(),
                'user_id' => $user->id,
                'file_type' => $file->getClientOriginalExtension(),
                'file_name' => urlencode($file->getClientOriginalName()),
            ]);
            FileList::create($params);
            return response()->json(array('path' => $path,'msg' => '上传成功'));
        }
    }

    public function uploadVideo(Request $request)
    {
//        if ($request->ajax() && \Auth::check()) {
            $user = \Auth::user();
            $type = env("VIDEOS_PAGE");
            switch ($type)
            {
                case "local":
                    $file = $request->file('file');
                    $videoPath = "/video/".date("Ymd");
                    // 第一个参数代表目录, 第二个参数代表我上方自己定义的一个存储媒介
                    $path = '/uploads/'.$file->storeAs($videoPath, urlencode($file->getClientOriginalName()),'uploads');
                    $params = array_merge([
                        'path' => $path,
                        'ip'   => $request->ip(),
                        'user_id' => $user->id,
                        'file_type' => $file->getClientOriginalExtension(),
                        'name' => urlencode($file->getClientOriginalName()),
                    ]);
                    VideoList::create($params);
                    return response()->json(array('path' => $path,'msg' => '上传成功'));
                case "cos":
                    $file = $request->file('video');
                    if($file->isValid()){
                        //获取原文件名
                        $originalName = $file->getClientOriginalName();
                        //扩展名
                        $ext = $file->getClientOriginalExtension();
                        //文件类型
                        $type = $file->getClientMimeType();
                        //临时绝对路径
                        $path = $file->getRealPath();
                        $cos = app("qcloudcos");
                        $cos::upload(env("QCLOUD_BUCKET"),$path,urlencode($originalName));
                    }
                    $params = array_merge([
                        'path' => env("QCLOUD_URL").'/'.$originalName,
                        'ip'   => $request->ip(),
                        'user_id' => $user->id,
                        'file_type' => $file->getClientOriginalExtension(),
                        'name' => urlencode($file->getClientOriginalName()),
                    ]);
                    VideoList::create($params);
                    return back()->withErrors("上传成功");
            }
//        }
    }

    public function videos()
    {
        $videos = VideoList::orderBy("created_at","desc")->paginate(10);
        return view("videos.index",compact("videos"));
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * $file->getClientOriginalName();   //获取文件名
     * $file->getFilename(); //缓存再tmp文件夹中的名字
     * $file->getRealPath();   //缓存在tmp文件夹的全路径
     */
    public function uploadPic(Request $request)
    {
        if ($request->ajax() && \Auth::check()) {
            $user = \Auth::user();
            $file = $request->file('file');
            $url = '';
            if(env('PICPATH') == PicList::QINIU)
            {
                $disk = \Storage::disk('qiniu'); //使用七牛云上传
                $filename = $disk->put($file->getClientOriginalExtension(), $file);//上传
                if(!$filename) {
                    return json_response(-1, '上传失败');
                }
                $path = env('QINIU_DOMAIN').$filename; //获取下载链接
                $url = $filename;
            }else
            {
                // 第一个参数代表目录, 第二个参数代表我上方自己定义的一个存储媒介
                $path = '/uploads/'.$file->store('pics', 'uploads');
            }

            $params = array_merge([
                'disk' => env('PICPATH'),
                'path' => $path,
                'ip'   => $request->ip(),
                'user_id' => $user->id,
                'file_type' => $file->getClientOriginalExtension(),
            ],['url'=>$url]);
            PicList::create($params);
            return response()->json(array('path' => $path));
        }
    }

    public function delPic(Request $request)
    {
        if($request->ajax() && \Auth::check())
        {
            if(User::isSuperAdmin())
            {
                $pic = PicList::find($request->id);
                if($pic->disk == 'local')
                {   //删除本地图片
                    if($delLocal = $this->delPicLocal($pic->path))
                    {
                        $pic->delete();
                        return \response()->json(array('msg'=>'删除本地图片成功','code'=>200));
                    }
                }elseif($pic->disk == 'qiniu')
                {   //删除七牛图片
                    if($delQn = $this->delPicQiniu($pic->url))
                    {
                        $pic->delete();
                        return \response()->json(array('msg'=>'删除七牛图片成功','code'=>200));
                    }
                }
            }else
            {
                return \response()->json('权限错误');
            }
        }
    }

    public function delVideo(VideoList $videoList)
    {

        if($this->delPicLocal($videoList->path))
        {
            $videoList->delete();
            return back();
        }else
        {
            $videoList->delete();
            return back();
        }
    }

    public function delFile(FileList $fileList)
    {

        if($this->delPicLocal($fileList->path))
        {
            $fileList->delete();
            return back();
        }
    }

    public function delAeth(Aether $aether)
    {
        if($aether->type == 2)
        {
            $cos = app('qcloudcos');
            $cosRes = $cos::delFile(env("QCLOUD_BUCKET"), $aether->name);
//            $cosRes = json_decode($cosRes,true);
            if($cosRes['message'] == "SUCCESS")
            {
                $aether->delete();
            }
            return back();
        }else
        {
            if($this->delPicLocal($aether->path))
            {
                $aether->delete();
                return back();
            }else
            {
                $aether->delete();
                return back()->withErrors("服务器视频文件未找到或已删除");
            }
        }
    }

    public function delPicQiniu($name)
    {
        $disk = \Storage::disk('qiniu');
        if($disk->exists($name))
        {
            return $disk->delete($name);
        }else
        {
            return false;
        }
    }

    public function delPicLocal($path)
    {
        if(is_file(public_path().$path))
        {
            return unlink(public_path().$path);
        }else
        {
            return false;
        }
    }

    public function picRet()
    {
        $pics = PicList::orderBy('created_at','desc')->get();
        foreach ($pics as $pic) {
            if($pic->disk == 'local')
            {
                if(is_file(public_path().$pic->path))
                {
                    $picJson[] = $pic;
                }
            }
            if($pic->disk == 'qiniu')
            {
                $disk = \Storage::disk('qiniu');
                if($disk->exists($pic->url))
                {
                    $picJson[] = $pic;
                }
            }
        }
        foreach ($picJson as $pic)
        {
            $pic->src = $pic->path;
        }
        return \response()->json([
           'title' => "图片管理",
            'id' => 'Images',
            'start' => 0,
            'data' => $picJson
        ]);
    }

    public function editPic()
    {
        return view('user.editpic');
    }

    public function clearAeth()
    {
        \Redis::del("aetherupload_file_hashes");
        return back()->withErrors("清空成功");
    }

    public function aethUpload()
    {
        $cate = Cate::orderBy("cate_order")->get();
        $aeths = Aether::orderBy("created_at","desc")->paginate(5);
        return view('aeahupload.index',compact('aeths','cate'));
    }

    public function aethUploadStore(Request $request)
    {
        if(!$request->type)
        {
            return back()->withErrors("请选择上传文件类型");
        }
        $user_ip = $request->ip();
        $user = \Auth::user();
        $storePath = config('aetherupload.UPLOAD_PATH').'/'.$request->path;
        if($request->type == "file")
        {
            if(env("AETHERS") == 'ali')
            {
                if(OSS::upload($request->name,$storePath))
                {
                    $path = OSS::getUrl($request->name);
                    unlink(config('aetherupload.UPLOAD_PATH').'/'.$request->path);
                }
                $type = 1;
            }else
            {
                if(!is_dir(public_path().'/uploads/aetheruoload/'.date('Ymd')))
                {
                    \File::makeDirectory(public_path().'/uploads/aetheruoload/'.date('Ymd'),0777,true,true);
                }
                $path = '/uploads/aetheruoload/'.date('Ymd').'/'.urlencode($request->name);
                if(copy($storePath,public_path().$path))
                {
                    unlink(config('aetherupload.UPLOAD_PATH').'/'.$request->path);
                }
                $type = 0;
            }
        }elseif($request->type == "video")
        {
            $cos = app("qcloudcos");
            $cosBack = $cos::upload(env("QCLOUD_BUCKET"),$storePath,$request->name);
            $cosBack = json_decode($cosBack,true);
            if($cosBack['code'] == "0")
            {
                $path = env("QCLOUD_URL").'/'.$request->name;
                unlink(config('aetherupload.UPLOAD_PATH').'/'.$request->path);
                $type = 2;
            }else
            {
                return back()->withErrors("上传文件到cos失败");
            }
        }
        $params = array_merge(request(['name','size']),['user_id'=>$user->id,'ip'=>$user_ip,'path'=>$path,'type'=>$type,'video_cate'=>'0']);
        Aether::create($params);
        return redirect()->route('aeth')->withErrors('上传成功');
    }

    public function videoList()
    {
        return view("videos.videoList");
    }

    public function videoListJson()
    {
        $videos = Aether::orderBy("created_at","desc")->get();
        foreach ($videos as $pic) {
            if($pic->type == 2)
            {
                $picJson[] = $pic;
            }else
            {
                if(is_file(public_path().$pic->path))
                {
                    $picJson[] = $pic;
                }
            }
        }
        foreach ($picJson as $pic)
        {
            if($pic->type == 1)
            {
                $pic->src = env("ALI_DOMAIN").'/'.$pic->name;
            }else
            {
                $pic->src = $pic->path;
            }
        }
        return \response()->json([
            'title' => "视频管理",
            'id' => 'Images',
            'start' => 0,
            'data' => $picJson,
        ]);
    }

    public function downMd(Post $post)
    {
        $info = "title: " . $post->title;
        $info = $info . "\ndate: " . $post->created_at->format('Y-m-d H:i');
        $info = $info . "\ncate: " . $post->cate->cate_name;
        $info = $info . "---\n\n" . $post->content;
        return response($info,200,[
            "Content-Type" => "application/force-download",
            'Content-Disposition' => "attachment; filename=\"".$post->title.".md\""
        ]);
    }

    public function test(Request $request)
    {

    }
}
