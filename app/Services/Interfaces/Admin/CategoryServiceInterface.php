<?php

namespace App\Services\Interfaces\Admin;

use App\Services\Interfaces\ServiceInterface;

interface CategoryServiceInterface extends ServiceInterface
{
    public function listCategory();
}
