<?php

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Admin\CountryRepositoryInterface;

class CountryRepository extends BaseRepository implements CountryRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Country::class;
    }

    public function getCountry()
    {
        return [];
    }
}
