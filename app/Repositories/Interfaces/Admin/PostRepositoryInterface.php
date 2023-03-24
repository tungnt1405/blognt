<?php

namespace App\Repositories\Interfaces\Admin;

use App\Repositories\Interfaces\RepositoryInterface;

interface PostRepositoryInterface extends RepositoryInterface
{
    public function updatePostInformation($postId, $postStatus);
    public function getAllPosts($conditions = [], $orders = [], $columns = ['*']);
    public function getAllPostsIncludeSoftDelete();
    public function getOnlyPostsSoftDelete($conditions = [], $orders = [], $columns = ['*']);
    public function restorePostSoftDelete($ids);
    public function deletePosts($ids);
    public function destroyPosts($ids);
}
