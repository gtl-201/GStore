<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class wareHouse extends Model
{
    protected $table = 'warehouse';
    protected $fillable = ['id','name','address','avatar','status'];
    static function createWarehouse($name, $address, $status, $avatar){
        return DB::insert('insert into `warehouse`(`name`, `address`, `status`, `avatar`) values (?, ?, ?, ?)', [$name, $address, $status, $avatar]);
    }
}
