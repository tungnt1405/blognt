<?php

namespace App\Services\Interfaces\Api;

use App\Services\Interfaces\ServiceInterface;

interface OwnerInfoServiceInterface extends ServiceInterface
{
    public function getOwnerInfoRepository();
}
