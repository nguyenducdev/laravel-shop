<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    protected $table = 'permission_role';

    protected $primaryKey = ['permission_id', 'role_id'];

    protected $fillable = ['permission_id', 'role_id'];

    public function permission() {
        return $this->hasOne('App\Models\Permission');
    }

    public function role() {
        return $this->hasOne('App\Models\Role');
    }
}

