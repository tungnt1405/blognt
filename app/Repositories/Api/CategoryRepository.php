<?php

namespace App\Repositories\Api;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Api\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getModel()
    {
        return \App\Models\Master\Category::class;
    }

    // Your methods for repository
    public function getTable()
    {
        return 'mtb_categories';
    }

    /**
     * Get Join Table
     */
    public function getJoinTable()
    {
        return [];
    }

    public function getCategories()
    {
        return $this->all();
    }
}
