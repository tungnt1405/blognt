<?php

namespace App\Services\Api;

use App\Services\AbstractService;
use App\Services\Interfaces\Api\OwnerServiceInterface;

class OwnerService extends AbstractService implements OwnerServiceInterface
{
    /**
     * OwnerService constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getRepository()
    {
        return \App\Repositories\Api\OwnerRepository::class;
    }

    public function getOwner()
    {
        try {
            return $this->repository->getOwner();
        } catch (\Exception $ex) {
            $this->loggerTry($ex);
            return $ex->getMessage();
        }
    }

    private function loggerTry($exception)
    {
        $this->logger('', $exception->getMessage(), config('constants.LOG_ERROR'));
    }
}
