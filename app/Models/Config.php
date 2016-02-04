<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'configs';

    protected $primaryKey = 'id';

    protected $fillable = ['config_key', 'config_value'];
}
