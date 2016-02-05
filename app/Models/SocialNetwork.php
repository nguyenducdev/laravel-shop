<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialNetwork extends Model
{
    protected $table = 'social_networks';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title', 'url', 'icon', 'status'
    ];
}
