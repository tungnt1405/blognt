<?php

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Admin\SideBarRepositoryInterface;

class SideBarRepository extends BaseRepository implements SideBarRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\SideBar::class;
    }

    public function getSideBar()
    {
        return [];
    }
}
