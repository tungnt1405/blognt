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

/**
 * TODO: 
 * Update bài viết khi có thay đổi nghiên cứu kỹ thuật như AJAX hoặc Server-Sent Events (SSE) (recomment nên dùng sse)
 * Bên fe gọi 1 endpoint event gửi qua bên laravel và laravel mpociot/laravel-sse
 * ví dụ check code 1
 * bên fe ví check code 2
 * check khoảng 1p mới update code 3
 * comment dùng redis và socketio
 * mục đích làm phần này học 1 số kỹ thuật cũng như học làm realtime 1 số chức năng
 * NOTE: hơi phức tạp hóa nhưng mà phục vụ tốt cho tương lại =))
 * làm được những phần note kia xóa all cmt
 */

// code 1
// use Mpociot\Ssrs\ServerSentEventsStream;
// use Illuminate\Http\Request;
// Route::put('/posts/{postId}', function (Request $request, $postId) {
//     // Lưu thông tin mới của bài post vào cơ sở dữ liệu
//     ...

//     // Gửi sự kiện SSE thông báo về sự thay đổi của bài post
//     $post = getPostById($postId);
//     $data = json_encode($post);
//     $sseStream = new ServerSentEventsStream();
//     $sseStream->setEvent('postUpdated');
//     $sseStream->setData($data);
//     return $sseStream->send();
// });

//code 2
// const sse = new EventSource("/posts/{postId}/sse");
// sse.addEventListener("postUpdated", event => {
//     const post = JSON.parse(event.data);
//     // Cập nhật nội dung mới lên UI
//     this.post = post;
// });

// code3
// Lưu trữ thời gian cập nhật cuối cùng của bài post
// let lastUpdatedTime = null;

// // Khi tác giả cập nhật bài post
// axios.put('/posts/' + postId, postData)
//     .then(response => {
//         // Gửi sự kiện SSE thông báo về sự thay đổi của bài post
//         const sseEndpoint = new EventSource('/posts/' + postId + '/sse');
//         sseEndpoint.onmessage = event => {
//             const currentTime = Date.now();
//             const post = JSON.parse(event.data);
//             // Kiểm tra xem thời gian cập nhật cuối cùng của bài post có cách nhiệt hơn 1 phút không
//             if (!// lastUpdatedTime || (currentTime - lastUpdatedTime) > 60000) {
//                 // Nếu thỏa mãn, cập nhật nội dung mới lên UI và cập nhật thời gian cập nhật cuối cùng
//                 this.post = post;
//                 lastUpdatedTime = currentTime;
//             }
//             // Nếu không, đợi thêm 1 phút và sau đó gửi yêu cầu SSE để lấy nội dung mới
//             else {
//                 setTimeout(() => {
//                     sseEndpoint.close();
//                     axios.get('/posts/' + postId)
//                         .then(response => {
//                             this.post = response.data;
//                             lastUpdatedTime = Date.now();
//                         })
//                         .catch(error => {
//                             console.log(error);
//                         });
//                 }, 60000);
//             }
//         };
//     })
//     .catch(error => {
//         console.log(error);
//    });
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
    public function show(Request $request, $id)
    {
        if (isset($id) && empty($this->postService->getPost($id, $request->get('post')))) {
            return response()->json([
                'code' => Response::HTTP_NOT_FOUND,
                'message' => 'Not Found Post',
                'data' => []
            ], Response::HTTP_NOT_FOUND);
        }

        $post = $this->postService->getPost($id, $request->get('post'));
        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => new PostResource($post)
        ], Response::HTTP_OK);
    }

    /**
     * 
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     */
    public function findSlug($slug)
    {
        if (isset($id) && empty($this->postService->getPost(null, $slug))) {
            return response()->json([
                'code' => Response::HTTP_NOT_FOUND,
                'message' => 'Not Found Post',
                'data' => []
            ], Response::HTTP_NOT_FOUND);
        }
        $post = $this->postService->getPost(null, $slug);
        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => new PostResource($post)
        ], Response::HTTP_OK);
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

    public function postSearch(Request $request)
    {
        $limit = $request->get('limit');
        $offset = $request->get('offset');
        $data = [
            'keywords' => $request->get('search'),
            'categories' => $request->get('categories'),
        ];
        if (empty($request->get('search')) && empty($request->get('categories'))) {
            return response()->json([
                'code' => Response::HTTP_OK,
                'total_post' => 0,
                'data'  => [],
                'pagination' => [
                    'limit' => 10,
                    'offset' => 0,
                    'offset_next' => 0,
                    'total_page' => 0,
                ]
            ], Response::HTTP_OK);
        }
        $posts = $this->postService->getPosts([], $limit, $offset, $data);
        return response()->json([
            'code' => Response::HTTP_OK,
            'total_post' => $posts['total'],
            'data'  => PostResource::collection($posts['posts']),
            'pagination' => [
                'limit' => (int) $limit,
                'offset' => (int) $offset,
                'offset_next' => ((int) $offset) + 1,
                'total_page' => ceil($posts['total_post'] / $limit),
            ]
        ], Response::HTTP_OK);
    }
    public function suggest(Request $request)
    {
        // sửa lại phần controller chuyển về xử lý bên service bên controller nhận các giá trị cần thiết để return
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

        return response()->json([
            'data' => $message,
        ], $code);
    }
}
