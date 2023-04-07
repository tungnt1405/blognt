<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\Interfaces\Api\PostServiceInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{
    /**
     * @var PostServiceInterface|\App\Services\Interfaces\Api
     */
    protected $postService;

    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $limit = !empty($data['limit']) ? $data['limit'] : 10;
        $posts = $this->postService->getPosts([], $limit, 0);

        if (gettype($posts) === 'string') {
            return response()->json([
                'code' => 500,
                'message' => 'Internal Server Error',
                'data' => $posts
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            'code' => Response::HTTP_OK,
            'total_post' => $posts['total'],
            'data'  => PostResource::collection($posts['posts']),
            'pagination' => [
                'per_page' => (int) $limit,
                'current_page' => 1,
                'total_page' => ceil($posts['total_post'] / $limit),
                'next_page' => 2,
            ]
        ], Response::HTTP_OK);
    }

    /**
     * 
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     */
    public function show(Post $post)
    {
    }

    /**
     * get more post
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     */
    public function morePosts(Request $request)
    {
        $data = $request->all();
        // vì offset truyền vào luôn lớn hơn giá trị cần lớn nên cần trừ đi 1 
        // ví dụ offset cần lấy là 2 thì request truyền vào đang là 3 vì thế cần trừ đi 1
        $posts = $this->postService->getPosts([], $data['limit'], --$data['offset']);

        if (gettype($posts) === 'string') {
            return response()->json([
                'code' => 500,
                'message' => 'Internal Server Error',
                'data' => $posts
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $total_page = ceil($posts['total_post'] / $data['limit']);
        $per_page = (int) $data['limit'];
        $current_page = ++$data['offset'];
        $next_page = $current_page + 1;
        $prev_page = $current_page - 1;
        $pagination = [
            'per_page' => $per_page,
            'current_page' => $current_page,
            'total_page' => $total_page,
        ];
        if ($prev_page >= 1) {
            $pagination['prev_page'] = $prev_page;
        }

        if ($next_page < $total_page) {
            $pagination['next_page'] = $next_page;
        }

        return response()
            ->json([
                'code' => Response::HTTP_OK,
                'total_post' => $posts['total'],
                'data' => PostResource::collection($posts['posts']),
                'pagination' => $pagination,
            ], Response::HTTP_OK);
    }
}
