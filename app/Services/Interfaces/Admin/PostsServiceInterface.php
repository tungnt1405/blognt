<?php

namespace App\Services\Interfaces\Admin;

use App\Services\Interfaces\ServiceInterface;

interface PostsServiceInterface extends ServiceInterface
{
    public function getAllPost($records = 10, $conditions = [], $orders = [], $columns = ['*']);
    public function findPost($id, $isTrash = false);
    public function insertPost($data = []);
    public function updatePost($id, $data = []);
    public function deletePosts($ids);
    public function destroyPosts($ids);
    public function updateStatusPost($postId, $postStatus);
    public function getAllPostsIncludeSoftDelete();
    public function getOnlyPostsSoftDelete($records = 10, $conditions = [], $orders = [], $columns = ['*']);
    public function restorePostSoftDelete($ids);
    public function listPosts($id = null);
}
