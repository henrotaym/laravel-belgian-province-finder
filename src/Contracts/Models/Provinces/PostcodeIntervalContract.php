<?php
namespace Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces;

interface PostcodeIntervalContract
{
    /**
     * Getting starting interval postcode.
     * 
     * @return int
     */
    public function getStart(): int;

    /**
     * Getting ending interval postcode.
     * 
     * @return int
     */
    public function getEnd(): int;

    /**
     * Telling if given postcode is included in range.
     * 
     * @param int $postcode
     * @return bool
     */
    public function isPostcodeIncluded(int $postcode): bool;
}