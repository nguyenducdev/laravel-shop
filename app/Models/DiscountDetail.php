<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountDetail extends Model
{
    protected $table = 'discount_details';

    protected $primaryKey = ['discount_id', 'product_id'];

    protected $fillable = ['discount_id', 'product_id'];

    public function discount() {
        return $this->belongsTo('App\Models\Discount');
    }

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }
}
