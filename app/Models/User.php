<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $table = "users";

    protected $primaryKey = "id";

    protected $fillable = [
        'email', 'password', 'name', 'phone', 'address', 'avatar', 'status', 'remember_token'
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function product() {
        return $this->hasMany('App\Models\Product');
    }

    public function roleUser() {
        return $this->belongsTo('App\Models\RoleUser');
    }

    public function order(){
        return $this->hasMany('App\Models\Order');
    }
    public function wishlist() {
        return $this->hasMany('App\Models\Wishlist');
    }
}