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
    public function updateColor(Request $request)
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
    public function destroyColor($id)
    {
        color::find($id)->delete();
        // return response()->json(['data'=>'removed'],200);
        return response()->json(['status' => 200, 'id' => $id]);
    }


    public function storeSize(Request $request)
    {
        $size = new size();
        $size -> size = $request -> size;
       
        $size -> save();
        return response()->json([
            'status' => 200,
            'data' => $size,
            'message' => 'Tạo kho thành công'
        ], 200);
    }
    function editSize($id)
    {
        $data = size::find($id);
        return response()->json($data);
    }
    public function updateSize(Request $request)
    {
        $size = size::find($request->id);
        $size -> size = $request -> size;

        $size->save();
        return response()->json([
            'status' => 200,
            'data' => $size,
            'message' => 'cap nhat kho thành công'
        ], 200); 
    }
    public function destroySize($id)
    {
        size::find($id)->delete();
        // return response()->json(['data'=>'removed'],200);
        return response()->json(['status' => 200, 'id' => $id]);
    }

    //==============================================================================================

    public function storeBrand(Request $request)
    {
        $brand = new brand();
        $brand -> brand = $request -> brand;
        if ($request->hasFile('image')) {
            $file = time() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public', $file);
            $patch = 'storage/' . $file;
            $brand -> image = $patch;
        };
        $brand -> save();
        return response()->json([
            'status' => 200,
            'data' => $brand,
            'message' => 'Tạo kho thành công'
        ], 200);
    }
    function editBrand($id)
    {
        $data = brand::find($id);
        return response()->json($data);
    }
    public function updateBrand(Request $request)
    {
        $brand = brand::find($request->id);
        $brand -> brand = $request -> brand;
        if ($request->hasFile('image')) {
            $file = time() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public', $file);
            $patch = 'storage/' . $file;
            $brand -> image = $patch;
        };
        $brand->save();
        return response()->json([
            'status' => 200,
            'data' => $brand,
            'message' => 'cap nhat kho thành công'
        ], 200); 
    }
    public function destroyBrand($id)
    {
        brand::find($id)->delete();
        // return response()->json(['data'=>'removed'],200);
        return response()->json(['status' => 200, 'id' => $id]);
    }
}
