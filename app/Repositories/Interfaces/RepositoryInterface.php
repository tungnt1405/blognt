<?php

namespace App\Repositories\Interfaces;

interface RepositoryInterface
{
    /**
     * Get all
     * @return mixed
     */
    public function all();

    /**
     * Get one
     * @param int $id
     * @return mixed
     */
    public function find($id);

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create($attributes = []);

    /**
     * Update
     * @param int $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, $attributes = []);

    /**
     * Delete
     * @param int $id
     * @return mixed
     */
    public function delete($id);

    /**
     * paginate
     * @param int $records
     * @param array $conditions
     */
    public function filterSearch($conditions = [], $orders = [], $columns = ['*']);
}
