<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminControler extends Controller
{
    function login(){
        return view('Admin.Access.login');
    }
    function index(){
        return view('Admin.Dashboard');
    }
    function icons(){
        return view('Admin.icons');
    }
}
