<?php

namespace App\Services\Api;

use App\Http\Resources\PostResource;
use App\Services\AbstractService;
use App\Services\Interfaces\Api\PostServiceInterface;

class PostService extends AbstractService implements PostServiceInterface
{
    public function getRepository()
    {
        return \App\Repositories\Api\PostRepository::class;
    }

    public function getPosts($columns = ['*'], $limit = 10, $offset = 0, $filterSearch = [])
    {
        try {
            if (!empty($filterSearch['categories'])) {
                $filterSearch['categories'] = explode(',', $filterSearch['categories']);
            }

            return $this->repository->getPosts($columns, $limit, $offset, $filterSearch);
        } catch (\Exception $ex) {
            $this->loggerTry($ex);
            return $ex->getMessage();
        }
    }

    public function getPost($id = null, $slug = '')
    {
        try {
            if (empty($id) && empty($slug)) {
                return [];
            }
            $post = $this->repository->getPost($id, $slug);
            return $post;
        } catch (\Exception $ex) {
            $this->loggerTry($ex);
            return [];
        }
    }

    public function suggestPosts($data)
    {
        try {
            return $this->repository->suggestPosts($data['category_id'], $data['post_id']);
        } catch (\Exception $ex) {
            $this->loggerTry($ex);
            return [];
        }
    }

    public function generateFileBySlugOfPost()
    {
        try {
            return [
                'total_record' => $this->repository->generateFileBySlugOfPost()->count(),
                'generate' => $this->convertFieldReturn($this->repository->generateFileBySlugOfPost()->toArray())
            ];
        } catch (\Exception $ex) {
            $this->loggerTry($ex);
            return [];
        }
    }

    protected function convertFieldReturn($data)
    {
        $newData = [];
        $listConvert =  ['id', 'posts_infomation'];
        foreach ($data as $key => $child) {
            foreach ($child as $filed => $value) {
                if (in_array($filed, $listConvert)) {
                    switch ($filed) {
                        case 'id':
                            $newData[$key]['post_id'] =  $value;
                            break;
                        default:
                            $newData[$key]['other_information'] = $value;
                            break;
                    }
                    continue;
                }
                $newData[$key][$filed] = $value;
            }
        }
        return $newData;
    }

    private function loggerTry($exception)
    {
        $this->logger('',  'Post API >>>' . $exception->getMessage(), config('constants.LOG_ERROR'));
    }
}
