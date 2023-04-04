<?php

namespace App\Repositories\Interfaces\Api;

use App\Repositories\Interfaces\RepositoryInterface;

interface PostRepositoryInterface extends RepositoryInterface
{
    public function getPosts($limit = 10, $offset = 0);
}
