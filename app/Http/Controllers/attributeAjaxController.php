<?php

namespace App\Http\Controllers;

use App\Models\brand;
use App\Models\color;
use App\Models\size;
use Illuminate\Http\Request;

class attributeAjaxController extends Controller
{
    public function indexColor()
    {
        $color = color::orderBy('id', 'desc')->get();

        return view('Admin.product.attribute.color', [
            'color' => $color,
        ]);
    }
    public function indexSize()
    {
        $size = size::orderBy('id', 'desc')->get();

        return view('Admin.product.attribute.size', [
            'size' => $size,
        ]);
    }
    public function indexBrand()
    {
        $brand = brand::orderBy('id', 'desc')->get();

        return view('Admin.product.attribute.brand', [
            'brand' => $brand,
        ]);
    }

    public function storeColor(Request $request)
    {
        $color = new color();
        $color -> color = $request -> color;
        $color -> hex =  $request -> hex;
       
        $color -> save();
        return response()->json([
            'status' => 200,
            'data' => $color,
            'message' => 'Tạo kho thành công'
        ], 200);
    }
    function editColor($id)
    {
        $data = color::find($id);
        return response()->json($data);
    }
    public function update(Request $request)
    {
        $color = color::find($request->id);
        $color -> color = $request -> color;
        $color -> hex =  $request -> hex;

        $color->save();
        return response()->json([
            'status' => 200,
            'data' => $color,
            'message' => 'cap nhat kho thành công'
        ], 200); 
    }

    public function destroy($id)
    {
        color::find($id)->delete();
        // return response()->json(['data'=>'removed'],200);
        return response()->json(['status' => 200, 'id' => $id]);
    }
}
