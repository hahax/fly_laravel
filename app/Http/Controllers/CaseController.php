<?php

namespace App\Http\Controllers;

use App\Cases;
use App\User;
use Illuminate\Http\Request;

class CaseController extends Controller
{
    public function index()
    {
        $admin = User::where('isadmin',1)->first();
        $cases = Cases::orderBy("case_sort")->paginate(12);
        return view('case.case',compact('cases','admin'));
    }
}
