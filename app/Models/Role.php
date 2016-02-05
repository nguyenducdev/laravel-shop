<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'label'];

    public function permissionRole() {
        return $this->belongsTo('App\Models\PermissionRole');
    }

    public function roleUser() {
        return $this->belongsTo('App\Models\RoleUser');
    }
}
