<?php

namespace App\Repositories\Api;

use App\Models\Owner;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Api\OwnerRepositoryInterface;

class OwnerRepository extends BaseRepository implements OwnerRepositoryInterface
{
    /**
     * Instantiate repository
     * 
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getModel()
    {
        return \App\Models\Owner::class;
    }

    // Your methods for repository
    public function getTable()
    {
        return 'dtb_owner';
    }

    /**
     * Get Join Table
     */
    public function getJoinTable()
    {
        return [];
    }
}
