<?php

namespace App\Services\Api;

use App\Services\AbstractService;
use App\Services\Interfaces\Api\OwnerInfoServiceInterface;

class OwnerInfoService extends AbstractService implements OwnerInfoServiceInterface
{
    /**
     * OwnerInfoService constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getRepository()
    {
        return \App\Repositories\Api\OwnerInfoRepository::class;
    }

    public function getOwnerInfoRepository()
    {
        return [];
    }
}
