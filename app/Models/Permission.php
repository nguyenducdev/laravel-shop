<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'label'];

    public function permissionRole() {
        return $this->hasMany('App\Models\PermissionRole');
    }
}
