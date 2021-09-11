<?php

namespace App\Http\Controllers;

use App\Models\transfer;
use Illuminate\Http\Request;

class transferController extends Controller
{
    public function index()
    {
        $transfer = transfer::orderBy('id', 'desc')->get();

        return view('Admin.warehouse.warehouse_transfer', [
            'transfer' => $transfer,
        ]);
    }
    public function store(Request $request)
    {
        $transfer = new transfer();
        $transfer -> id_product_detail = $request -> id_product_detail;
        $transfer -> id_admin = $request -> id_admin;
        $transfer -> id_warehouse = $request -> id_warehouse;
        $transfer -> id_warehouse_old = $request -> id_warehouse_old;
        $transfer -> date_transfer = $request -> date_transfer;
        $transfer -> quantity = $request -> quantity;
       
        $transfer -> save();
        return response()->json([
            'status' => 200,
            'data' => $transfer,
            'message' => 'Tạo kho thành công'
        ], 200);
    }
    function edit($id)
    {
        $data = transfer::find($id);
        return response()->json($data);
    }
    public function update(Request $request)
    {
        $transfer = transfer::find($request->id);
        $transfer -> id_product_detail = $request -> id_product_detail;
        $transfer -> id_admin = $request -> id_admin;
        $transfer -> id_warehouse = $request -> id_warehouse;
        $transfer -> id_warehouse_old = $request -> id_warehouse_old;
        $transfer -> date_transfer = $request -> date_transfer;
        $transfer -> quantity = $request -> quantity;

        $transfer->save();
        return response()->json([
            'status' => 200,
            'data' => $transfer,
            'message' => 'cap nhat kho thành công'
        ], 200); 
    }
    public function destroy($id)
    {
        transfer::find($id)->delete();
        // return response()->json(['data'=>'removed'],200);
        return response()->json(['status' => 200, 'id' => $id]);
    }
}
