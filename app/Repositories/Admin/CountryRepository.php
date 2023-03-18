<?php

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Admin\CountryRepositoryInterface;

class CountryRepository extends BaseRepository implements CountryRepositoryInterface
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getModel()
    {
        return \App\Models\Master\Country::class;
    }

    /**
     * Get table
     */
    public function getTable()
    {
        return 'mtb_countries';
    }

    /**
     * Get Join Table
     */
    public function getJoinTable()
    {
        return [];
    }

    /**
     * get all records from the country table
     * 
     * @return \App\Models\Master\Country|null
     */
    public function getAll()
    {
        return $this->all();
    }

    /**
     * create a new country
     * 
     * @param string $name
     * @param int $sort_no
     */
    public function insert($data)
    {
        $entity = $this->model->create($data);

        if ($entity) {
            return $entity->id;
        }

        return false;
    }

    /**
     * create a new country
     * 
     * @param int $id
     * @param string $name
     * @param int $sort_no
     */
    public function upgrade($id, $data)
    {
        return $this->update($id, $data);
    }
}
