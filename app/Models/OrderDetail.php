<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';

    protected $primaryKey = ['product_id', 'order_id'];

    protected $fillable = ['price', 'quantity', 'discount_id'];

    public function order() {
        return $this->belongsTo('App\Models\Order');
    }

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }
}
