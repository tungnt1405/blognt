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

    public function getPostRepository()
    {
        return [];
    }
}
