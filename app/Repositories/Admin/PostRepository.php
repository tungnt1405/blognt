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

    public function getModel()
    {
        return \App\Models\Post::class;
    }

    public function updatePostInformation($postId, $postStatus)
    {
        return $this->positionInformationRepository->getInfomationByPostId($postId, $postStatus);
    }

    public function getAllPostsIncludeSoftDelete()
    {
        return $this->model->withTrashed()->get();
    }

    public function getOnlyPostsSoftDelete()
    {
        return $this->model->onlyTrashed()->get();
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
