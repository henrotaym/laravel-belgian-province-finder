<?php
namespace Henrotaym\LaravelBelgianProvinceFinder\Contracts\Factories\Provinces;

use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces\ProvinceContract;

interface ProvinceFactoryContract
{
    /**
     * Creating a province based on given details.
     * 
     * @param array $data
     * @return ProvinceContract
     */
    public function create(array $data): ProvinceContract;
}