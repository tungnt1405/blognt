<?php

namespace App\Repositories\Interfaces\Admin;

interface OwnerInfoRepositoryInterface
{
    public function all();
    public function create($data = []);
    public function update($id, $data = []);
    public function find($id);
}
