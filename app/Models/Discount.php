<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = 'discounts';

    protected $primaryKey = 'id';

    protected $fillable = ['content', 'start_date', 'end_date'];

    public function discountDetail() {
        return $this->hasOne('App\Models\DiscountDetail');
    }
}
