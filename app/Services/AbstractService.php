<?php

namespace App\Services;

use App\Services\Interfaces\ServiceInterface;

abstract class AbstractService implements ServiceInterface
{
    /**
     * @var $repository
     */
    protected $repository;

    /**
     * AbstractService construct
    */
    public function __construct()
    {
        $this->setRepository();
    }

    /**
     * Get Repository
     */
    abstract public function getRepository();

    /**
     * Set Repository
     */
    public function setRepository()
    {
        $this->repository = app()->make(
            $this->getRepository()
        );
    }

    public function all()
    {
        // TODO: Implement all() method.
        return $this->repository->all();
    }

    public function find($id)
    {
        // TODO: Implement find() method.
        return $this->repository->find($id);
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        // TODO: Implement update() method.
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        return $this->repository->delete($id);
    }
}
