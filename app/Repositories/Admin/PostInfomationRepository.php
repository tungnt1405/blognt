<?php

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Admin\PostInfomationRepositoryInterface;

class PostInfomationRepository extends BaseRepository implements PostInfomationRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getModel()
    {
        return \App\Models\PostsInfomation::class;
    }

    /**
     * Get table
     */
    public function getTable()
    {
        return 'dtb_posts_infomation';
    }

    /**
     * Get Join Table
     */
    public function getJoinTable()
    {
        return [];
    }

    public function getInfomationByPostId($postId, $postStatus)
    {
        $postInformation = $this->model->where([
            'post_id' => $postId
        ]);

        if (empty($postInformation)) {
            return false;
        }

        $postInformation->update(['status' => $postStatus]);
        return $postInformation->get();
    }
}
