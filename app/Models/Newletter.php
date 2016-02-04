<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newletter extends Model
{
    protected $table = "newletters";

    protected $primaryKey = "id";

    protected $fillable = ['email'];
}
