<?php

namespace App\Http\Controllers;

use App\Models\imageProduct;
use App\Models\nameProduct;
use App\Models\productDetail;
use App\Models\receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class productController extends Controller
{
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
                ->where('id_warehouse', Session::get('warehouseChoosedId'))
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

        $allColor = DB::table('color')
            ->select([
                'id',
                'color',
            ])
            ->get();

        $allBrand = DB::table('brand')
            ->select([
                'id',
                'brand',
            ])
            ->get();

        $allSize = DB::table('size')
            ->select([
                'id',
                'size',
            ])
            ->get();

        $allType = DB::table('type_product')
            ->select([
                'id',
                'name',
            ])
            ->get();

        $allSupplier = DB::table('supplier')
            ->select([
                'id',
                'name',
                'address',
                'phone',
            ])
            ->get();

        // echo (Session::get('warehouseChoosedId'));
        // // echo ($allColor);
        // echo ('<br/>');
        // echo ($allSupplier);
        // echo ('<br/>');
        // echo ($allSize);
        // echo ('==================================================');
        return view('Admin.product.products.product', [
            'product' => $product,
            'allColor' => $allColor,
            'allBrand' => $allBrand,
            'allSize' => $allSize,
            'allType' => $allType,
            'allSupplier' => $allSupplier,
        ]);
    }

    public function storeproduct(Request $request)
    {
        $product = new nameProduct();
        $product->name = $request->name;
        $product->descrip = $request->descrip;
        $product->id_type = $request->typename;


        $product_detail = new productDetail();
        for ($i=1; $i <= $request->count; $i++) { 
            $product_detail[$i]->id_size = $request->input('size'.$i);
        }
        // for ($i=1; $i <= $request->count; $i++) {
        //     $product_detail[$i]->id_color = $request->input('color'.$i);
        // }
        // for ($i=1; $i <= $request->count; $i++) {
        //     $product_detail[$i]->price = $request->input('price'.$i);
        // }
        // for ($i=1; $i <= $request->count; $i++) {
        //     $product_detail[$i]->quantity = $request->input('quantity'.$i);
        // }
        // foreach ($product_detail as $keyDetail => $valueDetail) {
        //     $product_detail[$keyDetail]->id_product = $product->id;
        //     $product_detail[$keyDetail]->id_brand = $request->brand;
        //     $product_detail[$keyDetail]->id_warehouse = Session::get('warehouseChoosedId');
        //     $product_detail[$keyDetail]->save();
        // }


        // $receipt = new receipt();
        // foreach ($product_detail as $keyDetail => $valueDetail) {
        //     $receipt[$keyDetail]->id_product_detail = $valueDetail->id;
        //     $receipt[$keyDetail]->id_admin = Auth::guard('admin')->user()->id;
        //     $receipt[$keyDetail]->id_warehouse = Session::get('warehouseChoosedId');
        //     $receipt[$keyDetail]->id_supplier = $request->supplier;
        //     // $receipt[$keyDetail]->save();
        // }

        dd($request->size);
        // echo($receipt);
        echo('=====================================================');
        echo($product);
        echo('=====================================================');
        // echo($product_detail);

        $product->save();
        return response()->json([
            'status' => 200,
            // 'data' => $product,
            'SIZE' => $product_detail,
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
}
