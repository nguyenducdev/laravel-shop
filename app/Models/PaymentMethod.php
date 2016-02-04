<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'payment_methods';

    protected $primaryKey = 'id';

    protected $fillable = ['title', 'description', 'status'];

    public function order() {
        return $this->hasMany('App\Models\Order');
    }
}
