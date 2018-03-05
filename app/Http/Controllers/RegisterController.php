<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index');
    }   

    public function register()
    {
        $vercode = request('vercode');
        if (Session::get('milkcaptcha') !== $vercode)
        {
            return back()->withErrors('验证码错误')->withInput();
        }
        $this->validate(request(),[
            'email' => 'required|unique:users,email|email',
            'name' => 'required|min:3|unique:users,name',
            'password' => 'required|min:5|confirmed',
        ]);
        $password = bcrypt(request('password'));
        $name = request('name');
        $email = request('email');
        $user = User::create(compact('name','email','password'));
        return redirect('/login');
    }
}
