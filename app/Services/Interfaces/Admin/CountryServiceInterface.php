<?php

namespace App\Services\Interfaces\Admin;

use App\Services\Interfaces\ServiceInterface;

interface CountryServiceInterface extends ServiceInterface
{
    public function getAllCountries();
    public function insert($data);
}
