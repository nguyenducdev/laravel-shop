<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $fillable = [
            'title',
            'price',
            'old_price',
            'short_description',
            'description',
            'category_id',
            'brand_id',
            'user_id',
            'status',
            'avatar',
            'image',
            'view'
    ];
    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function brand(){
        return $this->belongsTo('App\Models\Brand');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function order(){
        return $this->belongsTo('App\Models\Order');
    }

    public function discountDetails() {
        return $this->hasMany('App\Models\DiscountDetail');
    }

    public function orderDetails() {
        return $this->hasMany('App\Models\OrderDetail');
    }

    public function wishlists() {
        return $this->hasMany('App\Models\Wishlist');
    }
}
