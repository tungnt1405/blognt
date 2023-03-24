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
        // $this->fields = $this->model->getFillable();
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
        return [
            'dtb_posts_infomation' => [
                'foreign_key' => 'post_id',
                'key' => 'id'
            ],
            'mtb_categories' => [
                'foreign_key' => 'id',
                'key' => 'category_id'
            ]
        ];
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

    public function getAllPosts($conditions = [], $orders = [], $columns = ['*'])
    {
        if (!empty($conditions) || !empty($orders) || $columns[0] !== '*') {
            return $this->filterSearch($conditions, $orders, $columns);
        } else {
            return $this->model->paginate(10);
        }
    }

    public function getAllPostsIncludeSoftDelete()
    {
        return $this->model->withTrashed();
    }

    public function getOnlyPostsSoftDelete($conditions = [], $orders = [], $columns = ['*'])
    {
        return $this->filterOnlyTrashSearch($conditions, $orders, $columns);
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
