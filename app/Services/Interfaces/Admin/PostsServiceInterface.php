<?php

namespace App\Services\Interfaces\Admin;

use App\Services\Interfaces\ServiceInterface;

interface PostsServiceInterface extends ServiceInterface
{
    public function getAllPost();
    public function paginate($page, $search = '');
    public function findPost($id);
    public function insertPost($data = []);
    public function updatePost($id, $data = []);
    public function deletePosts($ids);
    public function destroyPosts($ids);
    public function updateStatusPost($postId, $postStatus);
    public function getAllPostsIncludeSoftDelete();
    public function getOnlyPostsSoftDelete();
    public function restorePostSoftDelete($ids);
}
