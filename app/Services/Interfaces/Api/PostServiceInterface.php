<?php

namespace App\Services\Interfaces\Api;

use App\Services\Interfaces\ServiceInterface;

interface PostServiceInterface extends ServiceInterface
{
    public function getPostRepository();
}
