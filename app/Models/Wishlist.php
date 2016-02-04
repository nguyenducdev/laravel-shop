<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlists';

    protected $primaryKey = ['user_id', 'product_id'];

    protected $fillable = ['user_id', 'product_id'];

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }

    public function user() {
        return $this->belongsTo('App\Models\user');
    }
}
