<?php

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Admin\CountryRepositoryInterface;

class CountryRepository extends BaseRepository implements CountryRepositoryInterface
{

    public function __construct(){
        parent::__construct();
    }

    public function getModel()
    {
        return \App\Models\Master\Country::class;
    }

    public function getCountry()
    {
        return [];
    }
}
