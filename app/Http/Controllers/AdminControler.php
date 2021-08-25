<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminControler extends Controller
{
    function auth(){
        // if(Session::get('userName') === null){
            return redirect('admin/login');
        // }
    }
    function login(){
        return view('Admin.Access.login');
    }
    function index(){
        auth();
        return view('Admin.Dashboard');
    }
    function icons(){
        auth();
        return view('Admin.icons');
    }
    function product(){
        auth();
        return view('Admin.product');
    }

    function handleLogin(Request $result){
        $user = $result->user;
        $pass = $result->pass;
        $rs = Admin::login($user, $pass);
        if($rs){
            // print($rs);
            Session::put('userName',$user);
            return redirect('admin/dashboard');
        }else{
            // print($rs);
            Session::put('userName',null);
            return view('Admin.Access.login')->with('err', 'Tên đăng nhập hoặc mật khẩu không tồn tại');
        }
    }

    function handleLogout(){
        Session::put('userName',null);
        return redirect('admin/login');
    }
}
