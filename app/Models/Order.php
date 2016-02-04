<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'payment_method_id', 'name', 'email', 'phone', 'address', 'note', 'amount', 'status'
    ];

    public function user() {
        return $this->belongTo('App\Models\User');
    }

    public function payment_mothod() {
        return $this->belongTo('App\Models\PaymentMethod');
    }

    public function orderDetail() {
        return $this->hasOne('App\Models\OrderDetail');
    }
}
