<?php

namespace App\Repositories\Api;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Api\PostRepositoryInterface;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    /**
     * Instantiate repository
     * 
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getModel()
    {
        return \App\Models\Post::class;
    }

    // Your methods for repository
    public function getTable()
    {
        return 'dtb_posts';
    }

    /**
     * Get Join Table
     */
    public function getJoinTable()
    {
        return [];
    }

    public function getPosts($limit = 10, $offset = 0)
    {
        // inprogess get post
        return $this->model
            ->withTrashed()
            ->whereNull('deleted_at')
            ->skip($offset * $limit)
            ->take($limit)
            ->get();
    }
}
