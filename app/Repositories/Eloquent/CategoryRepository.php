<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\Repository;

class CategoryRepository extends Repository
{
    function model()
    {
        return 'App\Models\Category';
    }
}

?>