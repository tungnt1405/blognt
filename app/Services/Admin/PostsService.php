<?php

namespace App\Services\Admin;

use App\Services\AbstractService;
use App\Services\Interfaces\Admin\PostsServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PostsService extends AbstractService implements PostsServiceInterface
{
    /**
     * PostsService constructor
     */
    public function __construct()
    {
        parent::__construct();
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
            $data = array_merge($data, [
                'author_id' => $this->getUser()->id,
                'parent_id' => !empty($data['post_type']) && $data['post_type'] == '1' ? $data['parent_id'] : null
            ]);
            $this->logger('Insert Post', $data, config('constants.LOG_INFO'));
            $insertPost = $this->create($data);
            $insertPost->postsInfomation()->create([
                'status' => $data['status'] ?? 0,
                'public_date' => Carbon::parse($data['public_date'])
            ]);
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
            $updatePost = $this->update($id, $data);
            $updatePost->postsInfomation()->update([
                'status' => $data['status'] ?? 0,
                'public_date' => Carbon::parse($data['public_date'])
            ]);

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

    private function getUser()
    {
        return Auth::user();
    }

    private function loggerTry($exception)
    {
        $this->logger('', $exception->getMessage(), config('constants.LOG_ERROR'));
        DB::rollback();
        throw $exception;
    }
}
