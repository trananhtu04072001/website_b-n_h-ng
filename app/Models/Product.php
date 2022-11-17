<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Product extends Authenticatable
{
    use HasFactory;

    protected $table = 'products';

    public function orderdetail() {
        return $this->hasMany('App\Models\Orderdetail');
    }

    public function import() {
        return $this->hasMany('App\Models\Importdetail','id_product');
    }

    protected $fillable = [
        'name',
        'price',
        'image',
        'des',
        'view',
        'status',
        'id_brand',
        'id_type',
    ];
}
