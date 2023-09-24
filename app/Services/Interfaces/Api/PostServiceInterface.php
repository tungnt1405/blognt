<?php

namespace App\Services\Interfaces\Api;

use App\Services\Interfaces\ServiceInterface;

interface PostServiceInterface extends ServiceInterface
{
    public function getPosts($columns = ['*'], $limit = 10, $offset = 0, $filterSearch = []);
    public function getPost($id = null, $slug = '');
    public function suggestPosts($data);
    public function generateFileBySlugOfPost();
}
