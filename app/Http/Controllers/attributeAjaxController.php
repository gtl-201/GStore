<?php

namespace App\Http\Controllers;

use App\Models\brand;
use App\Models\color;
use App\Models\image;
use App\Models\nameProduct;
use App\Models\size;
use App\Models\type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function indeximage()
    {
        $image = image::orderBy('id', 'desc')->get();

        return view('Admin.product.attribute.image', [
            'image' => $image,
        ]);
    }
    public function indexType()
    {
        $type = type::orderBy('id', 'desc')->get();

        return view('Admin.product.attribute.type', [
            'type' => $type,
        ]);
    }
    public function indexProduct()
    {
        // $product = DB::table('product')
        // ->join('type_product','product.id_type','=','type_product.id')
        // ->select([
        //     'product.id',
        //     'product.id_type',
        //     'product.name',
        //     'product.descrip',
        //     'product.updated_at',
        //     'type_product.name as typename'])
        // ->get();
        $product = nameProduct::orderBy('id', 'desc')->get();
        return view('Admin.product.attribute.product', [
            'product' => $product,
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

    //==============================================================================================


    public function storeType(Request $request)
    {
        $type = new type();
        $type -> name = $request -> type;
       
        $type -> save();
        return response()->json([
            'status' => 200,
            'data' => $type,
            'message' => 'Tạo kho thành công'
        ], 200);
    }
    function editType($id)
    {
        $data = type::find($id);
        return response()->json($data);
    }
    public function updateType(Request $request)
    {
        $type = type::find($request->id);
        $type -> name = $request -> type;

        $type->save();
        return response()->json([
            'status' => 200,
            'data' => $type,
            'message' => 'cap nhat kho thành công'
        ], 200); 
    }
    public function destroyType($id)
    {
        type::find($id)->delete();
        // return response()->json(['data'=>'removed'],200);
        return response()->json(['status' => 200, 'id' => $id]);
    }


    //==============================================================================================


    public function storeproduct(Request $request)
    {
        $product = new nameProduct();
        $product -> id_type = $request -> id_type;
        $product -> name = $request -> name;
        $product -> descrip = $request -> descrip;
       
        $product -> save();
        return response()->json([
            'status' => 200,
            'data' => $product,
            'message' => 'Tạo kho thành công'
        ], 200);
    }
    function editproduct($id)
    {
        $data = nameProduct::find($id);
        return response()->json($data);
    }
    public function updateproduct(Request $request)
    {
        $product = nameProduct::find($request->id);
        $product -> id_type = $request -> id_type;
        $product -> name = $request -> name;
        $product -> descrip = $request -> descrip;

        $product->save();
        return response()->json([
            'status' => 200,
            'data' => $product,
            'message' => 'cap nhat kho thành công'
        ], 200); 
    }
    public function destroyproduct($id)
    {
        nameProduct::find($id)->delete();
        // return response()->json(['data'=>'removed'],200);
        return response()->json(['status' => 200, 'id' => $id]);
    }

    //==============================================================================================

    public function storeImage(Request $request)
    {
        $image = new image();
        $image -> id_product = $request -> id_product;
        if ($request->hasFile('image')) {
            $file = time() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public', $file);
            $patch = 'storage/' . $file;
            $image -> image = $patch;
        };
        $image -> save();
        return response()->json([
            'status' => 200,
            'data' => $image,
            'message' => 'Tạo kho thành công'
        ], 200);
    }
    function editImage($id)
    {
        $data = image::find($id);
        return response()->json($data);
    }
    public function updateImage(Request $request)
    {
        $image = image::find($request->id);
        $image -> id_product = $request -> id_product;
        if ($request->hasFile('image')) {
            $file = time() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public', $file);
            $patch = 'storage/' . $file;
            $image -> image = $patch;
        };
        $image->save();
        return response()->json([
            'status' => 200,
            'data' => $image,
            'message' => 'cap nhat kho thành công'
        ], 200); 
    }
    public function destroyImage($id)
    {
        image::find($id)->delete();
        // return response()->json(['data'=>'removed'],200);
        return response()->json(['status' => 200, 'id' => $id]);
    }
}
