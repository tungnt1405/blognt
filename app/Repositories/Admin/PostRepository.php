<?php

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Admin\PostRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    protected $positionInformationRepository;

    public function __construct()
    {
        parent::__construct();
        $this->setPostInformationRepository();
        // $this->fields = $this->model->getFillable();
    }

    /**
     * Get model
     */
    public function getModel()
    {
        return \App\Models\Post::class;
    }

    /**
     * Get table
     */
    public function getTable()
    {
        return $this->model->getTable();
    }

    /**
     * Get Join Table
     */
    public function getJoinTable()
    {
        return [
            'dtb_posts_infomation' => [
                'foreign_key' => 'post_id',
                'key' => 'id'
            ],
            'mtb_categories' => [
                'foreign_key' => 'id',
                'key' => 'category_id'
            ]
        ];
    }

    /**
     * @return \App\Repositories\Admin\PostInfomationRepository
     */
    private function getPostInformationRepository()
    {
        return PostInfomationRepository::class;
    }

    private function setPostInformationRepository(): void
    {
        $this->positionInformationRepository = app()->make($this->getPostInformationRepository());
    }

    public function updatePostInformation($postId, $postStatus)
    {
        $this->update($postId, [
            'updated_at' => \Carbon\Carbon::now()
        ]);
        return $this->positionInformationRepository->getInfomationByPostId($postId, $postStatus);
    }

    public function getAllPosts($records = 10, $conditions = [], $orders = [], $columns = ['*'])
    {
        return $this->filterSearch($records, $conditions, $orders, $columns);
    }

    public function getAllPostsIncludeSoftDelete()
    {
        return $this->model->withTrashed();
    }

    public function getOnlyPostsSoftDelete($records = 10, $conditions = [], $orders = [], $columns = ['*'])
    {
        return $this->filterOnlyTrashSearch($records, $conditions, $orders, $columns);
    }

    public function restorePostSoftDelete($ids)
    {
        $checkPostChildren = $this->model->withTrashed()->whereIn('parent_id', collect($ids));
        if ($checkPostChildren) {
            $checkPostChildren->restore();
        }
        return $this->model->withTrashed()->whereIn('id', collect($ids))->restore();
    }

    public function deletePosts($ids)
    {
        $checkPostChildren = $this->model->whereIn('parent_id', collect($ids));
        if ($checkPostChildren) {
            $checkPostChildren->delete();
        }
        return $this->model->destroy(collect($ids));
    }

    public function destroyPosts($ids)
    {
        $checkPostChildren = $this->model->withTrashed()->whereIn('parent_id', collect($ids));
        if ($checkPostChildren) {
            $checkPostChildren->forceDelete();
        }
        return $this->model->withTrashed()->whereIn('id', collect($ids))->forceDelete();
    }

    public function listPosts($id = null)
    {
        $list = $this->model
            // ->all()
            ->whereNull('parent_id')
            // ->sortBy('title', SORT_NATURAL | SORT_FLAG_CASE)
            ->orderBy('title', 'desc');

        if (isset($id)) {
            $list->where('id', '!=', $id);
        }

        return $list->pluck('title', 'id');
    }

    public function findPost($id, $isTrash = false)
    {
        if ($isTrash) {
            return $this->model->withTrashed()->where('id', $id)->firstOrFail();
        }

        return $this->find($id);
    }

    public function getPerPostByYear($year)
    {
        $query = $this->model
            ->whereYear('created_at', strval($year))
            ->whereBetween(DB::raw('MONTH(created_at)'), [1, 12])
            ->select(DB::raw('MONTH(created_at) as month , COUNT(*) AS per_of_month'))
            ->groupBy(DB::raw('MONTH(created_at)'));

        Log::info('Query: ', [
            'query' => $query->toSql(),
            'year' => $year,
            'month' => [1, 12],
        ]);

        return $query->get();
    }
}
