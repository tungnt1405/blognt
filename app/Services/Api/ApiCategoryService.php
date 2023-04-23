<?php

namespace App\Services\Api;

use App\Services\AbstractService;
use App\Services\Interfaces\Api\ApiCategoryServiceInterface;

class ApiCategoryService extends AbstractService implements ApiCategoryServiceInterface
{
    public function getRepository()
    {
        return \App\Repositories\Api\CategoryRepository::class;
    }

    public function getCategories()
    {
        try {
            return $this->repository->getCategories();
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
