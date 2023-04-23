<?php

namespace App\Services\Interfaces\Api;

use App\Services\Interfaces\ServiceInterface;

interface ApiCategoryServiceInterface extends ServiceInterface
{
    public function getCategories();
}
