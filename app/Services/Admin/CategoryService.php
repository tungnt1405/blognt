<?php

namespace App\Services\Admin;

use App\Services\AbstractService;
use App\Services\Interfaces\Admin\CategoryServiceInterface;

class CategoryService extends AbstractService implements CategoryServiceInterface
{
    /**
     * CategoryService constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getRepository()
    {
        return \App\Repositories\Admin\CategoryRepository::class;
    }

    public function listCategory()
    {
        return $this->repository->list();
    }
}
