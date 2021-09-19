<?php

namespace App\Http\Controllers;

use App\Models\image;
use App\Models\nameProduct;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class productController extends Controller
{
    function index()
    {
        $product = product::getAllProductDetail();
        return view('Admin.product.product', ['product' => $product]);
    }
    public function indeximage()
    {
        $image = image::orderBy('id', 'desc')->get();

        return view('Admin.product.attribute.image', [
            'image' => $image,
        ]);
    }
    public function indexProduct()
    {
        $product = DB::table('product')
            ->join('type_product', 'product.id_type', '=', 'type_product.id')
            ->select([
                'product.id',
                'product.id_type',
                'product.name',
                'product.descrip',
                'product.updated_at',
                'type_product.name as typename',
            ])
            ->get();

        $img_product = [];
        foreach ($product as $key => $value) {
            $img_product = DB::table('image')
                ->where('id_product', $value->id)
                ->get();
            $product[$key]->image = $img_product;
        }

        $product_detail = [];
        foreach ($product as $key => $value) {
            $product_detail = DB::table('product_detail')
                ->where('id_product', $value->id)
                ->get();
            $product[$key]->product_detail = $product_detail;
        }

        $receipt = [];
        foreach ($product as $keyP => $valueP) {
            foreach ($valueP->product_detail as $key => $value) {
                $receipt = DB::table('receipt')
                    ->where('id_product_detail', $value->id)
                    ->get();
                $product[$keyP]->product_detail[$key]->receipt = $receipt;
            }
        }

        $color = [];
        foreach ($product as $keyP => $valueP) {
            foreach ($valueP->product_detail as $key => $value) {
                $color = DB::table('color')
                    ->where('id', $value->id_color)
                    ->get();
                $product[$keyP]->product_detail[$key]->color = $color;
            }
        }

        $brand = [];
        foreach ($product as $keyP => $valueP) {
            foreach ($valueP->product_detail as $key => $value) {
                $brand = DB::table('brand')
                    ->where('id', $value->id_brand)
                    ->get();
                $product[$keyP]->product_detail[$key]->brand = $brand;
            }
        }

        $size = [];
        foreach ($product as $keyP => $valueP) {
            foreach ($valueP->product_detail as $key => $value) {
                $size = DB::table('size')
                    ->where('id', $value->id_size)
                    ->get();
                $product[$keyP]->product_detail[$key]->size = $size;
            }
        }

        $warehouse_transfer = [];
        foreach ($valueP->product_detail as $key => $value) {
            foreach ($product as $key => $value) {
                $warehouse_transfer = DB::table('warehouse_transfer')
                    ->where('id_product_detail', $value->id)
                    ->get();
                $product[$keyP]->product_detail[$key]->warehouse_transfer = $warehouse_transfer;
            }
        }

        $issue = [];
        foreach ($valueP->product_detail as $key => $value) {
            foreach ($product as $key => $value) {
                $issue = DB::table('issue')
                    ->where('id_product_detail', $value->id)
                    ->get();
                $product[$keyP]->product_detail[$key]->issue = $issue;
            }
        }

        $warehouse = [];
        foreach ($product as $keyP => $valueP) {
            foreach ($valueP->product_detail as $key => $value) {
                $warehouse = DB::table('warehouse')
                    ->where('id', $value->id_warehouse)
                    ->get();
                $product[$keyP]->product_detail[$key]->warehouse = $warehouse;
            }
        }

        $supplier = [];
        foreach ($valueP->product_detail as $key => $value) {
            foreach ($product as $key => $value) {
                foreach ($receipt as $keySuplier => $valueSuplier) {
                    // print_r($valueSuplier);
                    $supplier = DB::table('supplier')
                        ->where('id', $valueSuplier->id_supplier)
                        ->get();
                    $product[$keyP]->product_detail[$key]->receipt[$keySuplier]->supplier = $supplier;
                }
            }
        }

        echo ($product);
        echo ('==================================================');
        return view('Admin.product.products.product', [
            'product' => $product,
            'image' => $img_product,
        ]);
    }
    function getId(Request $res)
    {
        $product = $res->product;
        $size = $res->size;
        $hex = $res->hex;
        $brand = $res->brand;
        $warehouse = $res->warehouse;
        $quantity = $res->quantity;
        $price = $res->price;

        $idSize = DB::table('color')->select(['id'])->where('hex', '=', "'" . $hex . "'")->get();
        $idColor = DB::table('size')->select(['id'])->where('size', '=', "'" . $size . "'")->get();
        $idBrand = DB::table('brand')->select(['id'])->where('brand', '=', "'" . $brand . "'")->get();
        $idWarehouse = DB::table('warehouse')->select(['id'])->where('name', '=', "'" . $warehouse . "'")->get();

        $rs = product::insert($product, $idSize, $idColor, $idBrand, $idWarehouse, $quantity, $price);
        if ($rs) {
            return view('Admin.product.product');
        }
    }

    //==============================================================================================


    public function storeproduct(Request $request)
    {
        $product = new nameProduct();
        $product->id_type = $request->id_type;
        $product->name = $request->name;
        $product->descrip = $request->descrip;

        $product->save();
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
        $product->id_type = $request->id_type;
        $product->name = $request->name;
        $product->descrip = $request->descrip;

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
        $image->id_product = $request->id_product;
        if ($request->hasFile('image')) {
            $file = time() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public', $file);
            $patch = 'storage/' . $file;
            $image->image = $patch;
        };
        $image->save();
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
        $image->id_product = $request->id_product;
        if ($request->hasFile('image')) {
            $file = time() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public', $file);
            $patch = 'storage/' . $file;
            $image->image = $patch;
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
