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
    public function getAllCountries()
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
        $this->repository->create($data);
    }
}
