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
                // if($receipt){
                // $supplier = DB::table('supplier')
                //     ->where('id', $receipt->id_supplier)
                //     ->get();
                // $product[$keyP]->product_detail[$key]->receipt[$key] = $supplier;
                // }
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

        // $warehouse_transfer = [];
        // foreach ($product as $keyP => $valueP) {
        // foreach ($valueP->product_detail as $key => $value) {
        //     foreach ($product as $key => $value) {
        //         $warehouse_transfer = DB::table('warehouse_transfer')
        //             ->where('id_product_detail', $value->id)
        //             ->get();
        //         $product[$keyP]->product_detail[$key]->warehouse_transfer = $warehouse_transfer;
        //     }
        // }
        // }

        // $issue = [];
        // foreach ($valueP->product_detail as $key => $value) {
        //     foreach ($product as $key => $value) {
        //         $issue = DB::table('issue')
        //             ->where('id_product_detail', $value->id)
        //             ->get();
        //         $product[$keyP]->product_detail[$key]->issue = $issue;
        //     }
        // }

        $warehouse = [];
        foreach ($product as $keyP => $valueP) {
            foreach ($valueP->product_detail as $key => $value) {
                $warehouse = DB::table('warehouse')
                    ->where('id', $value->id_warehouse)
                    ->get();
                $product[$keyP]->product_detail[$key]->warehouse = $warehouse;
            }
        }

        // $supplier = [];
        //         foreach ($product as $keyP => $valueP) {
        // foreach ($valueP->product_detail as $key => $value) {
        //     foreach ($product as $key => $value) {
        //         foreach ($receipt as $keySuplier => $valueSuplier) {
        //             // print_r($valueSuplier);
        //             $supplier = DB::table('supplier')
        //                 ->where('id', $valueSuplier->id_supplier)
        //                 ->get();
        //             $product[$keyP]->product_detail[$key]->receipt[$keySuplier]->supplier = $supplier;
        //         }
        //     }
        // }
        //         }

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

        $product->save();

        for ($i=1; $i <= $request->count; $i++) {
            $product_detail = new productDetail();
            $product_detail->id_product = $product->id;
            $product_detail->id_size = $request->{'size'.$i};
            $product_detail->id_color = $request->{'color'.$i};
            $product_detail->id_brand = $request->brand;
            $product_detail->id_warehouse = Session::get('warehouseChoosedId');
            $product_detail->quantity = $request->{'quantity'.$i};
            $product_detail->price = $request->{'price'.$i};
            $product_detail->save();

            $receipt = new receipt();
            $receipt->id_product_detail = $product_detail->id;
            $receipt->id_admin = Auth::guard('admin')->user()->id;
            $receipt->id_warehouse = Session::get('warehouseChoosedId');
            $receipt->id_supplier = $request->supplier;
            $receipt -> save();
        }

        $product2 = DB::table('product')
            ->join('type_product', 'product.id_type', '=', 'type_product.id')
            ->select([
                'product.id',
                'product.id_type',
                'product.name',
                'product.descrip',
                'product.updated_at',
                'type_product.name as typename',
            ])
            ->where('product.id', $product->id)
            ->get();

        $img_product = [];
        foreach ($product2 as $key => $value) {
            $img_product = DB::table('image')
                ->where('id_product', $value->id)
                ->get();
            $product2[$key]->image = $img_product;
        }

        $product_detail2 = [];
        foreach ($product2 as $key => $value) {
            $product_detail2 = DB::table('product_detail')
                ->where('id_warehouse', Session::get('warehouseChoosedId'))
                ->where('id_product', $value->id)
                ->get();
            $product2[$key]->product_detail = $product_detail2;
        }

        $receipt = [];
        foreach ($product2 as $keyP => $valueP) {
            foreach ($valueP->product_detail as $key => $value) {
                $receipt = DB::table('receipt')
                    ->where('id_product_detail', $value->id)
                    ->get();
                $product2[$keyP]->product_detail[$key]->receipt = $receipt;
            }
        }

        $color = [];
        foreach ($product2 as $keyP => $valueP) {
            foreach ($valueP->product_detail as $key => $value) {
                $color = DB::table('color')
                    ->where('id', $value->id_color)
                    ->get();
                $product2[$keyP]->product_detail[$key]->color = $color;
            }
        }

        $brand = [];
        foreach ($product2 as $keyP => $valueP) {
            foreach ($valueP->product_detail as $key => $value) {
                $brand = DB::table('brand')
                    ->where('id', $value->id_brand)
                    ->get();
                $product2[$keyP]->product_detail[$key]->brand = $brand;
            }
        }

        $size = [];
        foreach ($product2 as $keyP => $valueP) {
            foreach ($valueP->product_detail as $key => $value) {
                $size = DB::table('size')
                    ->where('id', $value->id_size)
                    ->get();
                $product2[$keyP]->product_detail[$key]->size = $size;
            }
        }

        $warehouse = [];
        foreach ($product2 as $keyP => $valueP) {
            foreach ($valueP->product_detail as $key => $value) {
                $warehouse = DB::table('warehouse')
                    ->where('id', $value->id_warehouse)
                    ->get();
                $product2[$keyP]->product_detail[$key]->warehouse = $warehouse;
            }
        }

        return response()->json([
            'status' => 200,
            'data' => $product2,
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
