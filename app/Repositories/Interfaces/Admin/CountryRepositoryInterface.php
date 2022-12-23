<?php

namespace App\Repositories\Interfaces\Admin;

use App\Repositories\Interfaces\RepositoryInterface;

interface CountryRepositoryInterface extends RepositoryInterface
{
    public function getCountry();
}
