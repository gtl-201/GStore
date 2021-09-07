<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class productController extends Controller
{
    function index(){
        $product = product::getAllProductDetail();
        return view('Admin.product.product',['product'=>$product]);
    }
    function getId(Request $res){
        $product = $res->product;
        $size = $res->size;
        $hex = $res->hex;
        $brand = $res->brand;
        $warehouse = $res->warehouse;
        $quantity = $res->quantity;
        $price = $res->price;

        $idSize = DB::table('color')->select(['id'])->where('hex','=',"'".$hex."'")->get();
        $idColor = DB::table('size')->select(['id'])->where('size','=',"'".$size."'")->get();
        $idBrand = DB::table('brand')->select(['id'])->where('brand','=',"'".$brand."'")->get();
        $idWarehouse = DB::table('warehouse')->select(['id'])->where('name','=',"'".$warehouse."'")->get();

        $rs = product::insert($product,$idSize,$idColor,$idBrand,$idWarehouse,$quantity,$price);
        if($rs){
            return view('Admin.product.product');
        }
    }
}
