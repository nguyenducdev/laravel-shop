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
        return $this->belongsTo('App\Models\User');
    }

    public function paymentMethod() {
        return $this->belongsTo('App\Models\PaymentMethod');
    }

    public function orderDetails() {
        return $this->hasMany('App\Models\OrderDetail');
    }
}
