<?php

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Admin\OwnerRepositoryInterface;

class OwnerRepository extends BaseRepository implements OwnerRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Owner::class;
    }

    public function setOwnerAttributes($attr)
    {
        
    }
}
