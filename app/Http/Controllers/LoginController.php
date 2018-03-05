<?php

namespace App\Http\Controllers;

use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use LaravelChen\MyFlash\MyFlash;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function login(Request $request)
    {
        $vercode = request('vercode');
        if (Session::get('milkcaptcha') !== $vercode)
        {
            \myflash()->error('验证码错误','错误');
            return back()->withInput();
//            return back()->withErrors('验证码错误')->withInput();
        }

        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required|min:6|max:30',
            'is_remember' => '',
        ]);
        $user = request(['email','password']);
        $remember = boolval(request('is_remember'));
        if(true == \Auth::attempt($user,$remember))
        {
            return redirect('/posts');
        }
        return redirect()->back()->withErrors("用户名或密码错误")->withInput();
    }

    public function logout()
    {
        \Auth::logout();
        return redirect('/login');
    }

    public function captcha($tmp)
    {
        $build = new CaptchaBuilder();
        $build->build(100,36);
        $phr = $build->getPhrase();
        Session::flash('milkcaptcha',$phr);
        ob_clean();
        return response($build->output())->header('Content-type','image/jpeg');
    }
}
