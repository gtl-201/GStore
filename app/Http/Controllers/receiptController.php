<?php

namespace App\Http\Controllers;

use App\Models\receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class receiptController extends Controller
{
    public function index()
    {
        $receipt = DB::table('receipt')
        ->join('admin','receipt.id_admin','=','admin.id')
        ->join('warehouse','receipt.id_warehouse','=','warehouse.id')
        ->join('supplier','receipt.id_supplier','=','supplier.id')
        ->select('receipt.id','receipt.id_admin','receipt.id_product_detail','admin.name as adminName','warehouse.name as warehouseName','supplier.name as supplierName')
        ->get();

        $receipt_detail = [];
        foreach ($receipt as $key => $value) {
            $receipt_detail = DB::table('receipt_detail')
                ->join('supplier','supplier.id','=','receipt_detail.id_supplier')
                ->where('id_receipt', $value->id)
                ->get();
            $receipt[$key]->receiptDetail = $receipt_detail;
        }
        $admin = [];
        foreach ($receipt as $key => $value) {
            $admin = DB::table('admin')
                ->where('id', $value->id_admin)
                ->get();
            $receipt[$key]->admin = $admin;
        }

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
        // $data = receipt::find($id);
        return response()->json($id);
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
