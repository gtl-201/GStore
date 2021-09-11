<?php

namespace App\Http\Controllers;

use App\Models\issue;
use Illuminate\Http\Request;

class issueController extends Controller
{
    public function index()
    {
        $issue = issue::orderBy('id', 'desc')->get();

        return view('Admin.warehouse.issue', [
            'issue' => $issue,
        ]);
    }
    public function store(Request $request)
    {
        $issue = new issue();
        $issue -> id_product_detail = $request -> id_product_detail;
        $issue -> id_admin = $request -> id_admin;
        $issue -> id_warehouse = $request -> id_warehouse;
        $issue -> date_issue = $request -> date_issue;
        $issue -> quantity = $request -> quantity;
       
        $issue -> save();
        return response()->json([
            'status' => 200,
            'data' => $issue,
            'message' => 'Tạo kho thành công'
        ], 200);
    }
    function edit($id)
    {
        $data = issue::find($id);
        return response()->json($data);
    }
    public function update(Request $request)
    {
        $issue = issue::find($request->id);
        $issue -> id_product_detail = $request -> id_product_detail;
        $issue -> id_admin = $request -> id_admin;
        $issue -> id_warehouse = $request -> id_warehouse;
        $issue -> date_issue = $request -> date_issue;
        $issue -> quantity = $request -> quantity;

        $issue->save();
        return response()->json([
            'status' => 200,
            'data' => $issue,
            'message' => 'cap nhat kho thành công'
        ], 200); 
    }
    public function destroy($id)
    {
        issue::find($id)->delete();
        // return response()->json(['data'=>'removed'],200);
        return response()->json(['status' => 200, 'id' => $id]);
    }
}
