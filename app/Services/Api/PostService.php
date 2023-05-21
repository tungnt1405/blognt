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

    public function getPosts($columns = ['*'], $limit = 10, $offset = 0, $filterSearch = [])
    {
        try {
            if (!empty($filterSearch['categories'])) {
                $filterSearch['categories'] = explode(',', $filterSearch['categories']);
            }

            return $this->repository->getPosts($columns, $limit, $offset, $filterSearch);
        } catch (\Exception $ex) {
            $this->loggerTry($ex);
            return $ex->getMessage();
        }
    }

    public function getPost($id = null, $slug = '')
    {
        try {
            if (empty($id) && empty($slug)) {
                return [];
            }

            return $this->repository->getPost($id, $slug);
        } catch (\Exception $ex) {
            $this->loggerTry($ex);
            return $ex->getMessage();
        }
    }

    public function suggestPosts($data)
    {
        try {
            return $data;
        } catch (\Exception $ex) {
            $this->loggerTry($ex);
        }
    }

    private function loggerTry($exception)
    {
        $this->logger('', $exception->getMessage(), config('constants.LOG_ERROR'));
    }
}
