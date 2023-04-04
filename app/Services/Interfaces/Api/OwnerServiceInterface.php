<?php

namespace App\Services\Interfaces\Api;

use App\Services\Interfaces\ServiceInterface;

interface OwnerServiceInterface extends ServiceInterface
{
    public function getOwnerRepository();
}
