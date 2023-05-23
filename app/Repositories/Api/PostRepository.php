<?php

namespace App\Repositories\Api;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Api\PostRepositoryInterface;
use Carbon\Carbon;

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
        return [
            'dtb_posts_infomation' => [
                'foreign_key' => 'post_id',
                'key' => 'id'
            ],
            'mtb_categories' => [
                'foreign_key' => 'id',
                'key' => 'category_id'
            ],
            'users' => [
                'foreign_key' => 'id',
                'key' => 'author_id'
            ],
        ];
    }

    public function getPosts($columns = ['*'], $limit = 10, $offset = 0, $filterSearch = [])
    {
        $posts = $this->model
            ->withTrashed()
            ->whereNull('dtb_posts.deleted_at');

        foreach ($this->join as $table => $keys) {
            $posts->join($table, $table . '.' . $keys['foreign_key'], '=', $this->table . '.' . $keys['key']);
        }

        $posts->where('dtb_posts_infomation.status', 1)
            ->where('dtb_posts_infomation.public_date', '<=', Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s'));

        if (!empty($filterSearch)) {

            if ($filterSearch['keywords']) {
                $posts->where(function ($query) use ($filterSearch) {
                    $query->where('dtb_posts.title', 'like', '%' . trim($filterSearch['keywords']) . '%')
                        ->orWhere('dtb_posts.slug', 'like', '%' . trim($filterSearch['keywords']) . '%');
                });
            }
            if (!empty($filterSearch['categories'])) {
                $posts->whereIn('dtb_posts.category_id', $filterSearch['categories']);
            }
        }

        if (empty($columns) || is_array($columns) && in_array('*', $columns) || $columns === '*') {
            $posts->select(['dtb_posts.*']);
        } else {
            $posts->select($columns);
        }

        $posts
            ->skip($offset * $limit)
            ->take($limit)
            ->orderBy('dtb_posts.updated_at', 'DESC')
            ->orderBy('dtb_posts.id', 'DESC');

        return [
            'total' => $posts->get()->count(),
            'posts' => $posts->get(),
            'total_post' => $this->all()->count(),
        ];
    }

    public function getPost($id = null, $slug = '')
    {
        $post = $this->model->withTrashed()
            ->whereNull('dtb_posts.deleted_at');

        if (!empty($id)) {
            $post->where('id', $id);
        }

        if (!empty($slug)) {
            $post->where('slug', $slug);
        }
        return $post->firstOrFail();
    }

    public function suggestPosts($category_id, $post_id)
    {
        $post = $this->model->withTrashed()
            ->where('category_id', $category_id)
            ->whereNot('id', $post_id)
            ->whereNull('dtb_posts.deleted_at');
        return $post->get();
    }
}
