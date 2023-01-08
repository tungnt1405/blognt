<?php

namespace App\Repositories\Interfaces\Admin;

use App\Repositories\Interfaces\RepositoryInterface;

interface CountryRepositoryInterface extends RepositoryInterface
{
    public function all();
    public function insert($data);
    public function upgrade($id, $data);
}
