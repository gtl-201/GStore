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
            return redirect('admin/chooseWarehouse');
        }else{
            // print($rs);
            Session::put('userName',null);
            return view('Admin.Access.login')->with('err', 'Tên đăng nhập hoặc mật khẩu không tồn tại');
        }
    }

    function handleLogout(){
        Session::put('userName',null);
        Session::put('warehouseChoosed',null);
        return redirect('admin/login');
    }

    function chooseWarehouse(){
        $rs = Admin::getAllWareHouse();
        return view('Admin.ChooseWarehouse')->with('warehouseList',$rs);
    }
    function chooseWarehouseHandle(Request $rq){
        Session::put('warehouseChoosed', $rq->name);
        return redirect('admin/dashboard');
    }

    function allWarehouse(){
        $rs = Admin::getAllWarehouse();
        return view('Admin.warehouse')->with('warehouseList',$rs);
    }
}
