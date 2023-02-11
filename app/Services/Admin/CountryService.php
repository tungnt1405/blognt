<?php

namespace App\Services\Admin;

use App\Services\AbstractService;
use App\Services\Interfaces\Admin\CountryServiceInterface;

class CountryService extends AbstractService implements CountryServiceInterface
{
    /**
     * Country service constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getRepository()
    {
        return \App\Repositories\Admin\CountryRepository::class;
    }

    /**
     * get list record for country
     * 
     * @return \App\Models\Country
     */
    public function all()
    {
        return $this->repository->getAll();
    }

    /**
     * insert record for country table
     * 
     * @return boolean
     */
    public function insert($data)
    {
        return $this->repository->insert($data);
    }

    /**
     * update records for country table
     * 
     * @return array
     */
    public function update($id, array $data)
    {
        return $this->repository->upgrade($id, $data);
    }
}
