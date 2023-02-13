<?php
namespace Henrotaym\LaravelBelgianProvinceFinder\Contracts\Repositories\Provinces;

use Illuminate\Support\Collection;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces\ProvinceContract;
use Henrotaym\LaravelBelgianProvinceFinder\Models\Provinces\ProvinceKey;

interface ProvinceRepositoryContract
{
    /**
     * Finding province based on given postcode.
     * 
     * @param int $postcode
     * @return ?ProvinceContract
     */
    public function findByPostcode(int $postcode): ?ProvinceContract;

    /**
     * Finding province based on given unique key.
     * 
     * @param ProvinceKey $key
     * @return ?ProvinceContract
     */
    public function findByKey(ProvinceKey $key): ?ProvinceContract;

    /**
     * Getting all provinces.
     * 
     * @return Collection<int, ProvinceContract>
     */
    public function getAll(): Collection;
}