<?php
namespace Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models;

use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces\ProvinceContract;

interface IsProvinceRelatedModelContract
{
    /**
     * Getting column name where postcode is stored.
     * 
     * It can be nested in a JSON column without any problem.
     * 
     * @return string
     */
    public function getProvincePostcodeColumn(): string;

    /**
     * Getting province postcode
     * 
     * @return ?int
     */
    public function getProvincePostcodeValue(): ?int;

    /**
     * Getting province using postcode value.
     * 
     * @return ProvinceContract
     */
    public function getProvinceByPostcode(): ?ProvinceContract;
}