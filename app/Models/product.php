<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class product extends Model
{
    use HasFactory;
    static function getAllProductDetail(){
        return DB::table('product_detail')
        ->join('product','product_detail.id_product','=','product.id')
        ->join('image','product.id','=','image.id_product')
        ->join('size','product_detail.id_size','=','size.id')
        ->join('color','product_detail.id_color','=','color.id')
        ->join('brand','product_detail.id_brand','=','brand.id')
        ->join('warehouse','product_detail.id_warehouse','=','warehouse.id')
        ->select([
                    'product_detail.id',
                    'product_detail.quantity',
                    'product_detail.price',
                    'product_detail.created_at',
                    'product_detail.updated_at',
                    'product.name as nameProduct',
                    'image.image as imgProduct',
                    'size.size',
                    'color.color',
                    'color.hex',
                    'brand.brand',
                    'brand.image as imgBrand',
                    'warehouse.name as nameWarehouse',
                    'warehouse.avatar'])
                    ->get();
    }

    static function insert($product,$idSize,$idColor,$idBrand,$idWarehouse,$quantity,$price){
        return DB::insert('insert into product_detail (`id`, `id_product`, `id_size`, `id_color`, `id_brand`, `id_warehouse`, `quantity`, `price`, `created_at`, `updated_at`) values (?, ?)', [1, 'Dayle']);
    }
}
