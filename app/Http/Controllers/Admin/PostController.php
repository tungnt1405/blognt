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
        $orders = ['dtb_posts.updated_at' => 'desc', 'dtb_posts.id' => 'desc', 'dtb_posts.title' => 'asc'];
        $records = 10;
        $isTrash = false;
        $checkSearch = false;
        $searchTerm = '';
        $searchCategory = [];
        $searchStatus = '99';
        $searchParent = '1';
        $totalPosts = $this->postsService->getAllPost()->total();
        $totalPostsSoftDelete = $this->postsService->getOnlyPostsSoftDelete()->total();
        $posts = $this->postsService->getAllPost($records, [], $orders); // issue not orderby

        if (!empty($request->get('posts'))) {
            $posts = $this->postsService->getOnlyPostsSoftDelete($records, [], $orders);
            $isTrash = true;
        }

        $search = [];
        $data = $request->all();
        foreach ($data as $k => $v) {
            if ($k !== 'page' && $k !== 'posts') {
                $field = $this->setFieldSearch($k);

                if ($k === 'status' && $v == '99') {
                    continue;
                }

                if ($k === 'search' && !empty($v)) {
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
            if ($search[$this->setFieldSearch('parent')] == '1') {
                $search[$this->setFieldSearch('parent')] = NULL;
            } else {
                $search[$this->setFieldSearch('parent')] = $data['search'];

                if (!empty($search[$this->setFieldSearch('search')])) {
                    unset($search[$this->setFieldSearch('search')]);
                }
            }

            $checkSearch = true;
            $searchTerm = $request->get('search');
            $searchCategory = $request->get('category');
            $searchStatus = $request->get('status');
            $searchParent = $request->get('parent');
            if ($isTrash) {
                $posts = $this->postsService->getOnlyPostsSoftDelete($records, $search, $orders, $columns);
            } else {
                $search['dtb_posts.deleted_at'] = NULL;
                $posts = $this->postsService->getAllPost($records, $search, $orders, $columns);
            }
        }

        return view('admin.posts.index', compact('posts'))
            ->with('isTrash', $isTrash)
            ->with('checkSearch', $checkSearch)
            ->with('searchTerm', $searchTerm)
            ->with('searchStatus', $searchStatus)
            ->with('searchParent', $searchParent)
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
            ->with('checkPost', false)
            ->with('isTrash', false)
            ->with('listPosts', $this->postsService->listPosts())
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
    public function edit($id)
    {
        $post = $this->postsService->findPost($id);
        $listPosts = $listPosts = $this->postsService->listPosts($id);
        $isTrash = false;
        if (!$post) {
            $isTrash = true;
            $post = $this->postsService->findPost($id, true);
        }
        return view('admin.posts.create')
            ->with('checkPost', true)
            ->with('post', $post)
            ->with('listPosts', $listPosts)
            ->with('isTrash', $isTrash)
            ->with('categories', $this->categoryService->listCategory());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $update = $this->postsService->updatePost($id, $request->toArray());

        if ($update) {
            $this->toastrSuccess('Updated successfully', 'Success');
        } else {
            $this->toastrError('Updated Failed', 'Error');
        }
        return back();
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
            'id' => 'dtb_posts.id',
            'search' => 'dtb_posts.title',
            'status' => 'dtb_posts_infomation.status',
            'category' => 'dtb_posts.category_id',
            'parent' => 'dtb_posts.parent_id',
        ];

        return $fields[$field] ?? '';
    }
}
