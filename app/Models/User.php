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
}