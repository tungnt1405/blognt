<?php

namespace App\Repositories\Admin;

use App\Models\OwnerInfo;
use App\Repositories\Interfaces\Admin\OwnerInfoRepositoryInterface;

class OwnerInfoRepository implements OwnerInfoRepositoryInterface
{
    protected $model;

    /**
     * Instantiate repository
     * 
     * @param OwnerInfo $model
     */
    public function __construct(OwnerInfo $model)
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

    public function find($id)
    {
        return $this->model->find($id);
    }
}
