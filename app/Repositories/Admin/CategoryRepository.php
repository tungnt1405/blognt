<?php

namespace App\Repositories\Admin;

use App\Models\Master\Category;
use App\Repositories\Interfaces\Admin\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected $model;

    /**
     * Instantiate reporitory
     * 
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    // Your methods for repository
    public function all()
    {
        return $this->model->all();
    }

    public function create($data = [])
    {
        return $this->model->create($data);
    }

    public function update($id, $data = [])
    {
        $result = $this->find($id);

        if ($result) {
            $result->update($data);
            return $result;
        }

        return false;
    }

    public function list()
    {
        return $this->all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->pluck('name', 'id');
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }
}
