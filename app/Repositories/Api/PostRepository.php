<?php

namespace App\Repositories\Api;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Api\PostRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;

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

    private function queryPost()
    {
        return $this->model::with(['user', 'category', 'postsInfomation'])
            ->whereHas('postsInfomation', function ($query) {
                $date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
                $query->where('public_date', '<=', $date)
                    ->where('status', true);
            })
            ->withTrashed()
            ->whereNull('deleted_at');
    }

    public function getPosts($columns = ['*'], $limit = 10, $offset = 0, $filterSearch = [])
    {
        $posts = $this->queryPost();

        $posts->select($columns ?: '*')
            ->where(function ($query) use ($filterSearch) {
                if (!empty($filterSearch['keywords'])) {
                    $query->where(function ($query) use ($filterSearch) {
                        $query->where('title', 'like', '%' . trim($filterSearch['keywords']) . '%')
                            ->orWhere('slug', 'like', '%' . trim($filterSearch['keywords']) . '%');
                    });
                }
                if (!empty($filterSearch['categories'])) {
                    $query->whereIn('category_id', $filterSearch['categories']);
                }
            })
            ->skip($offset * $limit)
            ->take($limit)
            ->orderBy('updated_at', 'DESC')
            ->orderBy('id', 'DESC');

        return [
            'total' => $posts->count(),
            'posts' => $posts->get(),
        ];
    }

    public function getPost($id = null, $slug = '')
    {
        $post = $this->queryPost();

        return $post->where(function ($query) use ($id, $slug) {
            if (!empty($id)) {
                $query->where('id', $id);
            }

            if (!empty($slug)) {
                $query->where('slug', $slug);
            }
        })->firstOrFail();
    }

    public function suggestPosts($category_id, $post_id)
    {
        $post = $this->queryPost();
        return $post->where('category_id', $category_id)
            ->whereNot('id', $post_id)
            ->get();
    }

    public function generateFileBySlugOfPost()
    {
        return $this->model::with(['postsInfomation' => function ($query) {
            $query->select('post_id', 'meta_content as seo_content');
        }])
            ->whereHas('postsInfomation', function ($query) {
                $date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
                $query->where('public_date', '<=', $date)
                    ->where('status', true);
            })
            ->withTrashed()
            ->whereNull('deleted_at')->select('id', 'title as post_name', 'slug as post_slug')
            ->orderBy('updated_at', 'DESC')
            ->orderBy('id', 'DESC')->get();
    }
}
