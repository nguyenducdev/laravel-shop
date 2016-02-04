<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $tables= 'role_user';

    protected $primaryKey = ['role_id', 'user_id'];

    protected $fillable = ['role_id', 'user_id'];

    public function role() {
        return $this->hasOne('App\Models\Role');
    }

    public function user() {
        return $this->hasOne('App\Models\User');
    }
}
