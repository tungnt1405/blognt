<?php

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Admin\PostRepositoryInterface;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    protected $positionInformationRepository;

    public function __construct()
    {
        parent::__construct();
        $this->setPostInformationRepository();
    }

    /**
     * Get model
     */
    public function getModel()
    {
        return \App\Models\Post::class;
    }

    /**
     * Get table
     */
    public function getTable()
    {
        return $this->model->getTable();
    }

    /**
     * Get Join Table
     */
    public function getJoinTable()
    {
        return [];
    }

    /**
     * @return \App\Repositories\Admin\PostInfomationRepository
     */
    private function getPostInformationRepository()
    {
        return PostInfomationRepository::class;
    }

    private function setPostInformationRepository(): void
    {
        $this->positionInformationRepository = app()->make($this->getPostInformationRepository());
    }

    public function updatePostInformation($postId, $postStatus)
    {
        return $this->positionInformationRepository->getInfomationByPostId($postId, $postStatus);
    }

    public function paginatePosts($conditions = [], $orders = [], $records = 10, $columns = ['*'])
    {
        return $this->paginate($conditions, $orders, $records, $columns);
    }

    public function getAllPostsIncludeSoftDelete()
    {
        return $this->model->withTrashed()->paginate(10);
    }

    public function getOnlyPostsSoftDelete()
    {
        return $this->model->onlyTrashed()->paginate(10);
    }

    public function restorePostSoftDelete($ids)
    {
        return $this->model->withTrashed()->whereIn('id', collect($ids))->restore();
    }

    public function deletePosts($ids)
    {
        return $this->model->destroy(collect($ids));
    }

    public function destroyPosts($ids)
    {
        return $this->model->withTrashed()->whereIn('id', collect($ids))->forceDelete();
    }
}
