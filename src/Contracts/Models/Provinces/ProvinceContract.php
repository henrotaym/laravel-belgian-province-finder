<?php
namespace Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces;

use Illuminate\Support\Collection;
use Henrotaym\LaravelBelgianProvinceFinder\Models\Provinces\ProvinceKey;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces\PostcodeIntervalContract;

interface ProvinceContract
{
    /**
     * Getting province name.
     * 
     * @return string
     */
    public function getName(): string;

    /**
     * Getting province unique key.
     * 
     * @return ProvinceKey
     */
    public function getKey(): ProvinceKey;

    /**
     * Getting related postcode intervals.
     * 
     * @return Collection<int, PostcodeIntervalContract>
     */
    public function getPostcodeIntervals(): Collection;

    /**
     * Telling if given postcode is included in province.
     * 
     * @param int $postcode
     * @return bool
     */
    public function isPostcodeIncluded(int $postcode): bool;
}