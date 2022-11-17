<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reorder extends Model
{
    use HasFactory;

    protected $table = 'reorders';

    public function product() {
        return $this->belongsTo('App\Models\Product' , 'product_id');
    }

    public function ship() {
        return $this->belongsTo('App\Models\Ship' , 'ship_id');
    }

    public function user() {
        return $this->belongsTo('App\Models\User' , 'user_id');
    }

    public function order() {
        return $this->belongsTo('App\Models\Order' , 'order_id');
    }
    protected $fillable = [
        'product_id',
        'des',
        'user_id',
        'ship_id',
        'order_id',
    ];
}
