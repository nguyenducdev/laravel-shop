<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title', 'parent_id', 'description', 'image', 'status'
    ];

    public function product() {
        return $this->hasMany('App\Models\Product');
    }
}
