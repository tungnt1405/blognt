<?php

namespace App\Repositories\Interfaces\Admin;

use App\Repositories\Interfaces\RepositoryInterface;

interface OwnerRepositoryInterface extends RepositoryInterface
{
    public function setOwnerAttributes($attr);
}
