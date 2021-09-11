<?php

namespace App\Http\Controllers;

use App\Models\receipt;
use Illuminate\Http\Request;

class receiptController extends Controller
{
    public function index()
    {
        $receipt = receipt::orderBy('id', 'desc')->get();

        return view('Admin.warehouse.receipt', [
            'receipt' => $receipt,
        ]);
    }
    public function store(Request $request)
    {
        $receipt = new receipt();
        $receipt -> id_product_detail = $request -> id_product_detail;
        $receipt -> id_admin = $request -> id_admin;
        $receipt -> id_warehouse = $request -> id_warehouse;
        $receipt -> id_supplier = $request -> id_supplier;
        $receipt -> date_receipt = $request -> date_receipt;
        $receipt -> quantity = $request -> quantity;
       
        $receipt -> save();
        return response()->json([
            'status' => 200,
            'data' => $receipt,
            'message' => 'Tạo kho thành công'
        ], 200);
    }
    function edit($id)
    {
        $data = receipt::find($id);
        return response()->json($data);
    }
    public function update(Request $request)
    {
        $receipt = receipt::find($request->id);
        $receipt -> id_product_detail = $request -> id_product_detail;
        $receipt -> id_admin = $request -> id_admin;
        $receipt -> id_warehouse = $request -> id_warehouse;
        $receipt -> id_supplier = $request -> id_supplier;
        $receipt -> date_receipt = $request -> date_receipt;
        $receipt -> quantity = $request -> quantity;

        $receipt->save();
        return response()->json([
            'status' => 200,
            'data' => $receipt,
            'message' => 'cap nhat kho thành công'
        ], 200); 
    }
    public function destroy($id)
    {
        receipt::find($id)->delete();
        // return response()->json(['data'=>'removed'],200);
        return response()->json(['status' => 200, 'id' => $id]);
    }
}
