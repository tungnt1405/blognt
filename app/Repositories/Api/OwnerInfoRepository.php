<?php

namespace App\Repositories\Api;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Api\OwnerInfoRepositoryInterface;

class OwnerInfoRepository extends BaseRepository implements OwnerInfoRepositoryInterface
{
    /**
     * Instantiate repository
     * 
     */
    public function __construct()
    {
        parent::__construct();
    }

    // Your methods for repository
    public function getModel()
    {
        return \App\Models\OwnerInfo::class;
    }

    // Your methods for repository
    public function getTable()
    {
        return 'dtb_owner_info';
    }

    /**
     * Get Join Table
     */
    public function getJoinTable()
    {
        return [];
    }
}
