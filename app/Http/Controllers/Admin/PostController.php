<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\admin\Posts\StorePostRequest;
use App\Http\Requests\admin\Posts\UpdatePostRequest;
use App\Models\Post;
use App\Services\Interfaces\Admin\CategoryServiceInterface;
use App\Services\Interfaces\Admin\PostsServiceInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class PostController extends AdminController
{
    /**
     * @var CategoryServiceInterface $categoryService
     */
    protected $categoryService;

    /**
     * @var PostsServiceInterface $postService
     */
    protected $postsService;

    public function __construct(CategoryServiceInterface $categoryService, PostsServiceInterface $postsService)
    {
        $this->categoryService = $categoryService;
        $this->postsService = $postsService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create')
            ->with('categories', $this->categoryService->listCategory());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $input = $request->toArray();
        $insert = $this->postsService->insertPost($input);

        if ($insert) {
            $this->toastrSuccess('Inserted successfully', 'Success');
            return redirect()->route('admin.posts');
        }

        $this->toastrError('Insert Failed', 'Error');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $post = $this->postsService->destroyPosts($request->get('ids'));

        if (!$post) {
            $this->toastrError('Sorry! Delete failed.', 'Error');
            return response()
                ->json([
                    'code' => 500,
                    'message' => 'Sorry! Delete posts failed.',
                ]);
        }

        $this->toastrSuccess('Successfully delete posts', 'Success');
        return response()->json([
            'code' => 200,
            'message' => 'Successfully delete posts'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function softDeletePosts(Request $request)
    {
        $post = $this->postsService->deletePosts($request->get('ids'));

        if (!$post) {
            $this->toastrError('Sorry! Delete failed.', 'Error');
            return response()
                ->json([
                    'code' => 500,
                    'message' => 'Sorry! Delete posts failed.',
                ]);
        }

        $this->toastrSuccess('Successfully delete posts', 'Success');
        return response()->json([
            'code' => 200,
            'message' => 'Successfully delete posts'
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $updatePost = $this->postsService->updateStatusPost($id, $request->get('status'));

        if ($updatePost === false) {
            $this->toastrError('Sorry! Updating status failed.', 'Error');
            return response()
                ->json([
                    'code' => 500,
                    'message' => 'Sorry! Updating status failed.',
                ]);
        }

        $this->toastrSuccess('Successfully change post status', 'Success');
        return response()
            ->json([
                'code' => 200,
                'message' => 'Successfully change post status',
            ]);
    }
}
