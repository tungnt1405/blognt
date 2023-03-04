<?php

namespace App\Repositories\Interfaces\Admin;

use App\Repositories\Interfaces\RepositoryInterface;

interface PostRepositoryInterface extends RepositoryInterface
{
    public function updatePostInformation($postId, $postStatus);
    public function getAllPostsIncludeSoftDelete();
    public function getOnlyPostsSoftDelete();
    public function restorePostSoftDelete($ids);
    public function deletePosts($ids);
    public function destroyPosts($ids);
    public function paginatePosts($conditions = [], $orders = [], $records = 10, $columns = ['*']);
}
