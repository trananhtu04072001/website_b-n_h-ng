<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtrProduct extends Model
{
    use HasFactory;

    protected $table = 'atrproducts';

    protected $fillable = [
        'id_product',
        'id_atr',
    ];

    public function product() {
        return $this->belongsTo('App\Models\Product','id_product');
    }

    public function atr() {
        return $this->belongsTo('App\Models\Atribute','id_atr');
    }
}
