<?php

namespace App\Repositories\Interfaces\Api;

use App\Repositories\Interfaces\RepositoryInterface;

interface PostRepositoryInterface extends RepositoryInterface
{
    public function getPosts($columns = ['*'], $limit = 10, $offset = 0);
    public function getPost($id = null, $slug = '');
}
