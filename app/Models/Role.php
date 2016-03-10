<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'label'];

    public function permissionRoles() {
        return $this->hasMany('App\Models\PermissionRole');
    }

    public function roleUsers() {
        return $this->hasMany('App\Models\RoleUser');
    }
}
