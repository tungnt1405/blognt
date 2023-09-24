<?php

namespace App\Services\Admin;

use App\Services\AbstractService;
use App\Services\Interfaces\Admin\PostsServiceInterface;
use App\Services\UploadFileService;
use App\Utils\RedisUtil;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostsService extends AbstractService implements PostsServiceInterface
{
    /**
     * @var UploadFileService
     */
    protected $_uploadFileService;
    private static $instance;

    /**
     * PostsService constructor
     */
    public function __construct(
        UploadFileService $uploadFileService
    ) {
        parent::__construct();
        $this->_uploadFileService = $uploadFileService;
    }

    public static function singleton()
    {
        if (!self::$instance) {
            $upload = new UploadFileService();
            self::$instance = new PostsService($upload);
        }

        return self::$instance;
    }

    public function getRepository()
    {
        return \App\Repositories\Admin\PostRepository::class;
    }

    public function getAllPost($records = 10, $conditions = [], $orders = [], $columns = ['*'])
    {
        try {
            return $this->repository->getAllPosts($records, $conditions, $orders, $columns);
        } catch (\Exception $e) {
            $this->loggerTry($e);
        }
    }

    public function countPostByMonth()
    {
        try {
            return $this->repository->countPostByMonth();
        } catch (\Exception $e) {
            $this->loggerTry($e);
        }
    }

    public function findPost($id, $isTrash = false)
    {
        try {
            $this->logger('Find Post', [$id], config('constants.LOG_INFO'));
            return $this->repository->findPost($id, $isTrash);
        } catch (\Exception $e) {
            $this->loggerTry($e);
        }
    }

    public function insertPost($data = [])
    {
        try {
            $base_64 = !empty($data['thumbnail_posts']) ? $this->_uploadFileService->moveFileImage($data['thumbnail_posts']) : null;
            if (!empty($data['thumbnail_posts_copy']) && empty($data['thumbnail_posts'])) {
                $base_64 = $this->_uploadFileService->copyImage($data['thumbnail_posts_copy']);
            }
            $data = array_merge($data, [
                'author_id' => $this->getUser()->id,
                'parent_id' => !empty($data['post_type']) && $data['post_type'] == '1' ? $data['parent_id'] : null,
                'thumbnail_posts' => $base_64
            ]);

            $this->logger('Insert Post', $data, config('constants.LOG_INFO'));
            $insertPost = $this->create($data);
            $dataInfo = [
                'status' => $data['status'] ?? 0,
                'public_date' => Carbon::parse($data['public_date']),
                'meta_content' => $data['meta_content']
            ];
            $this->logger('Insert Post info', $dataInfo, config('constants.LOG_INFO'));
            $insertPost->postsInfomation()->create($dataInfo);
            if ($insertPost) {
                $this->clearCachePosts();
            }
            return $insertPost;
        } catch (\Exception  $e) {
            $this->loggerTry($e);
        }
    }

    public function updatePost($id, $data = [])
    {
        try {
            $data = array_merge($data, [
                'series' => $data['series'] ?? 0,
                'parent_id' => !empty($data['post_type']) && $data['post_type'] == '1' ? $data['parent_id'] : null,
                'update_at' => \Carbon\Carbon::now()
            ]);
            $post = $this->find($id);
            $base_64 = !empty($data['thumbnail_posts']) ? $this->_uploadFileService->moveFileImage($data['thumbnail_posts']) : null;
            if ($post->count() > 0 && isset($base_64)) {
                Storage::disk('public')->delete('images/' . $post->thumbnail_posts);
                $data['thumbnail_posts'] = $base_64;
            }
            $this->logger('Update Post: ' . $id, $data, config('constants.LOG_INFO'));
            $updatePost = $this->update($id, $data);
            $dataInfo = [
                'status' => $data['status'] ?? 0,
                'public_date' => Carbon::parse($data['public_date']),
                'meta_content' => $data['meta_content'] ?? null
            ];
            $this->logger('Update Post info', $dataInfo, config('constants.LOG_INFO'));
            $updatePost->postsInfomation()->update($dataInfo);

            if ($updatePost) {
                $this->clearCachePosts();
            }

            return $updatePost;
        } catch (\Exception $e) {
            $this->loggerTry($e);
        }
    }

    public function deletePosts($ids)
    {
        try {
            $this->logger('Soft Delete Posts', $ids, config('constants.LOG_INFO'));
            return $this->repository->deletePosts($ids);
        } catch (\Exception $e) {
            $this->loggerTry($e);
        }
    }

    public function destroyPosts($ids)
    {
        try {
            $this->logger('Delete Posts', $ids, config('constants.LOG_INFO'));
            foreach ($ids as $id) {
                $post = $this->findPost($id, true);
                if ($post->count() > 0) {
                    Storage::disk('public')->delete('images/' . $post->thumbnail_posts);
                }
            };
            return $this->repository->destroyPosts($ids);
        } catch (\Exception $e) {
            $this->loggerTry($e);
        }
    }

    public function updateStatusPost($postId, $postStatus)
    {
        try {
            DB::beginTransaction();
            $post = $this->repository->updatePostInformation($postId, $postStatus);
            DB::commit();
            if (!empty($post)) {
                $this->logger('Update Post Information', $post->toArray(), config('constants.LOG_INFO'));
                $this->clearCachePosts();
                return true;
            }

            $this->logger('', $post, config('constants.LOG_ERROR'));
            return false;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->loggerTry($e);
        }
    }

    public function getAllPostsIncludeSoftDelete()
    {
        try {
            return $this->repository->getAllPostsIncludeSoftDelete();
        } catch (\Exception $e) {
            $this->loggerTry($e);
        }
    }
    public function getOnlyPostsSoftDelete($records = 10, $conditions = [], $orders = [], $columns = ['*'])
    {
        try {
            return $this->repository->getOnlyPostsSoftDelete($records, $conditions, $orders, $columns);
        } catch (\Exception $e) {
            $this->loggerTry($e);
        }
    }

    public function listPosts($id = null)
    {
        try {
            return $this->repository->listPosts($id);
        } catch (\Exception $e) {
            $this->loggerTry($e);
        }
    }

    public function restorePostSoftDelete($ids)
    {
        try {
            $this->logger('Restore Posts', $ids, config('constants.LOG_INFO'));
            return $this->repository->restorePostSoftDelete($ids);
        } catch (\Exception $e) {
            $this->loggerTry($e);
        }
    }

    public function getPerPostByYear($year)
    {
        try {
            return $this->repository->getPerPostByYear($year);
        } catch (\Exception $e) {
            $this->loggerTry($e);
        }
    }

    private function getUser()
    {
        return Auth::user();
    }

    private function clearCachePosts()
    {
        return RedisUtil::deleteKey('posts');
    }

    private function loggerTry($exception)
    {
        $this->logger('', $exception->getMessage(), config('constants.LOG_ERROR'));
        DB::rollback();
        throw $exception;
    }
}
