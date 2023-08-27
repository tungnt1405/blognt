<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\Interfaces\Api\PostServiceInterface;
use App\Utils\CommonUtil;
use App\Utils\RedisUtil;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
            Log::error('Get all posts', [$posts]);
            return CommonUtil::responeJson([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Internal Server Error',
                'data' => []
            ], Response::HTTP_OK);
        }
        if (empty(RedisUtil::checkKey('posts'))) {
            RedisUtil::setKey('posts', PostResource::collection($posts['posts']), 24 * 60 * 60);
        }

        return CommonUtil::responeJson([
            'code' => Response::HTTP_OK,
            'total_post' => $posts['total'],
            'data'  => RedisUtil::getKey('posts'),
            'pagination' => [
                'per_page' => (int) $limit,
                'current_page' => 1,
                'total_page' => ceil($posts['total'] / $limit),
                'next_page' => 2,
            ]
        ]);
    }

    /**
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     */
    public function show(Request $request, $id)
    {
        $post = $this->postService->getPost($id, $request->get('post'));
        if (isset($id) && (empty($post) || empty($post->postsInfomation))) {
            return CommonUtil::responeJson([
                'code' => Response::HTTP_NOT_FOUND,
                'message' => 'Post not found.',
                'data' => []
            ], Response::HTTP_OK);
        }

        return CommonUtil::responeJson([
            'code' => Response::HTTP_OK,
            'data' => new PostResource($post)
        ]);
    }

    /**
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     */
    public function findSlug($slug)
    {
        $post = $this->postService->getPost(null, $slug);
        if (isset($slug) && empty($post)) {
            return CommonUtil::responeJson([
                'code' => Response::HTTP_NOT_FOUND,
                'message' => 'Post not found.',
                'data' => []
            ], Response::HTTP_OK);
        }

        return CommonUtil::responeJson([
            'code' => Response::HTTP_OK,
            'data' => new PostResource($post)
        ]);
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
            Log::error('Get all posts', [$posts]);
            return CommonUtil::responeJson([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Internal Server Error',
                'data' => []
            ], Response::HTTP_OK);
        }

        $total_page = ceil($posts['total'] / $data['limit']);
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

        return CommonUtil::responeJson([
            'code' => Response::HTTP_OK,
            'total_post' => $posts['total'],
            'data' => PostResource::collection($posts['posts']),
            'pagination' => $pagination,
        ]);
    }

    public function postSearch(Request $request)
    {
        $limit = $request->get('limit');
        $offset = $request->get('offset');
        $data = [
            'keywords' => $request->get('search'),
            'categories' => $request->get('categories'),
        ];
        if (empty($request->get('search')) && empty($request->get('categories'))) {
            return CommonUtil::responeJson([
                'code' => Response::HTTP_OK,
                'total_post' => 0,
                'data'  => [],
                'pagination' => [
                    'limit' => 10,
                    'offset' => 0,
                    'offset_next' => 0,
                    'total_page' => 0,
                ]
            ]);
        }
        $posts = $this->postService->getPosts([], $limit, $offset, $data);
        return CommonUtil::responeJson([
            'code' => Response::HTTP_OK,
            'total_post' => $posts['total'],
            'data'  => PostResource::collection($posts['posts']),
            'pagination' => [
                'limit' => (int) $limit,
                'offset' => (int) $offset,
                'offset_next' => ((int) $offset) + 1,
                'total_page' => ceil($posts['total'] / $limit),
            ]
        ]);
    }
    public function suggest(Request $request)
    {
        $data = $request->all();
        $message = '';
        $isError = false;
        $code = Response::HTTP_OK;

        if (empty($data)) {
            $isError = true;
            $message = trans('client/validation.server_error');
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        } elseif (empty($data['category_id'])) {
            $isError = true;
            $message = trans('client/validation.suggest.not_eligible', ['value' => 'category_id']);
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        } elseif (empty($data['post_id'])) {
            $isError = true;
            $message = trans('client/validation.suggest.not_eligible', ['value' => 'post_id']);
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        if (!$isError) {
            $suggest = $this->postService->suggestPosts($data);
            if (empty($suggest)) {
                $message = trans('client/validation.suggest.not_found');
                $code = Response::HTTP_NOT_FOUND;
            } else {
                $message = PostResource::collection($suggest);
            }
        }

        return CommonUtil::responeJson([
            'code' => $code,
            'data' => $message
        ], $code);
    }
}
