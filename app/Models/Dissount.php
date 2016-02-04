<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dissount extends Model
{
    protected $table = 'discounts';

    protected $primaryKey = 'id';

    protected $fillable = ['email'];
}
