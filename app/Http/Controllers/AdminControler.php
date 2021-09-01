<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminControler extends Controller
{
    function login()
    {
        return view('Admin.Access.login');
    }
    function index()
    {
        return view('Admin.Dashboard');
    }
    function icons()
    {
        return view('Admin.icons');
    }
    function product()
    {
        return view('Admin.product');
    }

    function handleLogin(Request $result)
    {   
        
        $data = [
            'user_name' => $result->user,
            'password' => $result->pass
        ];
        if (Auth::guard('admin')->attempt($data)) {
            
            return redirect('admin/chooseWarehouse');
        }
        else{
            
            return redirect()->back()->with('err', 'Tên đăng nhập hoặc mật khẩu không tồn tại');

        }
    }

    function handleLogout()
    {
        Auth::guard('admin')->logout();
        Session::put('warehouseChoosed', null);
        return redirect('admin/login');
    }

    function chooseWarehouse()
    {
        $rs = Admin::getAllWareHouse();
        return view('Admin.ChooseWarehouse')->with('warehouseList', $rs);
    }
    function chooseWarehouseHandle(Request $rq)
    {
        Session::put('warehouseChoosed', $rq->name);
        return redirect('admin/dashboard');
    }

    // function allWarehouse()
    // {
    //     $rs = Admin::getAllWarehouse();
    //     return view('Admin.warehouse.warehouse')->with('warehouseList', $rs);
    // }

    function addWarehouse(Request $result)
    {
        $name = $result->name;
        $address = $result->address;
        $status = $result->status;
        $file = time() . "." . $result->file('avt')->getClientOriginalExtension();
        $result->file('avt')->storeAs('public', $file);
        $avt = 'storage/' . $file;

        $rs = Admin::createWarehouse($name, $address, $avt, $status);
        if ($rs) {
            return redirect()->back()->with('err', 'Tạo kho thành công');
        } else {
            return redirect()->back()->with('err', 'Tạo kho thất bại');
        }
    }

    
}
