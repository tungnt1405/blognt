<?php

namespace App\Services\Admin;

use App\Services\AbstractService;
use App\Services\Interfaces\Admin\OwnerInfoServiceInterface;

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
        return \App\Repositories\Admin\OwnerInfoRepository::class;
    }
}
