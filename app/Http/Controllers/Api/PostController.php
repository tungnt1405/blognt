<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use App\Services\Interfaces\Api\PostServiceInterface;
use Illuminate\Http\Response;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postService->getPosts();

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
        ], Response::HTTP_OK);
    }
}
