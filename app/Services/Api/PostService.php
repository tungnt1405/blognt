<?php

namespace App\Services\Api;

use App\Services\AbstractService;
use App\Services\Interfaces\Api\PostServiceInterface;

class PostService extends AbstractService implements PostServiceInterface
{
    public function getRepository()
    {
        return \App\Repositories\Api\PostRepository::class;
    }

    public function getPosts($columns = ['*'], $limit = 10, $offset = 0)
    {
        try {
            return $this->repository->getPosts($columns, $limit, $offset);
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
