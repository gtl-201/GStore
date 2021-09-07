<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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
    
    public function indexAccount()
    {
        $account = Admin::orderBy('id', 'desc')->get();

        return view('Admin.account.account', [
            'account' => $account,
        ]);
    }
    public function addAccount(Request $res){
        
        $validator = Validator::make($res->all(), [
            'name' => 'required|max:30',
            'email' => 'required|max:255',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif',
            'pass' => 'required|max:18|min:4',
            'user_name' => 'required|max:50',
            'address' => 'required|max:250',
            'roles' => 'required',
            'phone' => 'required|max:10|min:10',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
                'data' => $res->id
            ],400);
        } else{
            $account = new Admin();
            $account ->name = $res->name; 
            if ($res->hasFile('avatar')) {
                $file = time() . "." . $res->file('avatar')->getClientOriginalExtension();
                $res->file('avatar')->storeAs('public', $file);
                $patch = 'storage/' . $file;
                $account -> avartar = $patch;
            };
            $account ->email = $res->email;
            $account ->user_name = $res->user_name;
            $account ->phone = $res->phone;
            $account ->address = $res->address;
            $account ->password = bcrypt($res->pass);
            $account ->roles = $res->roles;
    
            $account ->save();
            return response()->json([
                'status' => 200,
                'data' => $account,
                'message' => 'Tạo tài khoản thành công'
            ], 200);
        }
        
        
    }
    function editAccount($id)
    {
        $data = Admin::find($id);
        return response()->json($data);
    }
    function updateAccount(Request $res){
        // $validator = Validator::make($res->all(), [
        //     'name' => 'required|max:30',
        //     'email' => 'required|max:255',
        //     'avatar' => 'image|mimes:jpeg,png,jpg,gif',
        //     'user_name' => 'required|max:50',
        //     'address' => 'required|max:250',
        //     'roles' => 'required',
        //     'phone' => 'required|max:10|min:10',
        // ]);
        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 400,
        //         'errors' => $validator->messages(),
        //         'data' => $res->id
        //     ],400);
        // } else{
            $account = Admin::find($res->id);
            $account ->name = $res->name; 
            if ($res->hasFile('avatar')) {
                $file = time() . "." . $res->file('avatar')->getClientOriginalExtension();
                $res->file('avatar')->storeAs('public', $file);
                $patch = 'storage/' . $file;
                $account -> avartar = $patch;
            };
            $account ->email = $res->email;
            $account ->user_name = $res->user_name;
            $account ->phone = $res->phone;
            $account ->address = $res->address;
            $account ->roles = $res->roles;
    
            $account ->save();
            return response()->json([
                'status' => 200,
                'data' => $account,
                'message' => 'Cập nhật khoản thành công'
            ], 200);
        // }
    }
    public function destroyAccount($id)
    {
        Admin::find($id)->delete();
        // return response()->json(['data'=>'removed'],200);
        return response()->json(['status' => 200, 'id' => $id]);
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
