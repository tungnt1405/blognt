<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\admin\Posts\StorePostRequest;
use App\Http\Requests\admin\Posts\UpdatePostRequest;
use App\Models\Post;
use App\Services\Interfaces\Admin\CategoryServiceInterface;
use App\Services\Interfaces\Admin\PostsServiceInterface;
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
    public function index(Request $request)
    {
        $columns = ['dtb_posts.*', 'dtb_posts_infomation.status', 'dtb_posts_infomation.public_date', 'mtb_categories.name'];
        $isTrash = false;
        $checkSearch = false;
        $searchterm = '';
        $searchCategory = [];
        $searchStatus = '1';
        $totalPosts = $this->postsService->getAllPost()->total();
        $totalPostsSoftDelete = $this->postsService->getOnlyPostsSoftDelete()->total();
        $posts = $this->postsService->getAllPost();

        if (!empty($request->get('posts'))) {
            $posts = $this->postsService->getOnlyPostsSoftDelete();
            $isTrash = true;
        }

        $search = [];
        foreach ($request->all() as $k => $v) {
            if ($k !== 'page' && $k !== 'posts') {
                $field = $this->setFieldSearch($k);
                if ($k === 'search' && isset($v) && $v !== '') {
                    $v = [
                        'sql' => 'Like',
                        'value' => "%" . trim($v) . "%"
                    ];
                }
                if (isset($v) && $v !== '') {
                    $search[$field] = $v;
                }
            }
        }

        if (isset($search) && $search) {
            $checkSearch = true;
            $searchterm = $request->get('search');
            $searchCategory = $request->get('category');
            $searchStatus = $request->get('status');
            if ($isTrash) {
                $posts = $this->postsService->getOnlyPostsSoftDelete($search, ['dtb_posts.id' => 'desc', 'dtb_posts.title' => 'asc'], $columns);
            } else {
                $orders = ['dtb_posts.id' => 'DESC'];
                $search['dtb_posts.deleted_at'] = NULL;
                $posts = $this->postsService->getAllPost($search, $orders, $columns);
            }
        }
        return view('admin.posts.index', compact('posts'))
            ->with('isTrash', $isTrash)
            ->with('checkSearch', $checkSearch)
            ->with('searchterm', $searchterm)
            ->with('searchStatus', $searchStatus)
            ->with('searchCategory', $searchCategory)
            ->with('totalPosts', $totalPosts)
            ->with('totalPostsSoftDelete', $totalPostsSoftDelete);
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

    public function restorePosts(Request $request)
    {
        $restorePosts = $this->postsService->restorePostSoftDelete($request->get('ids'));

        if (!$restorePosts) {
            $this->toastrError('Sorry! Restore failed.', 'Error');
            return response()
                ->json([
                    'code' => 500,
                    'message' => 'Sorry! Restore failed',
                ]);
        }

        $this->toastrSuccess('Successfully restore posts', 'Success');
        return response()->json([
            'code' => 200,
            'message' => 'Successfully restore posts'
        ]);
    }

    private function setFieldSearch($field)
    {
        $fields = [
            'search' => 'dtb_posts.title',
            'status' => 'dtb_posts_infomation.status',
            'category' => 'dtb_posts.category_id'
        ];

        return $fields[$field];
    }
}
