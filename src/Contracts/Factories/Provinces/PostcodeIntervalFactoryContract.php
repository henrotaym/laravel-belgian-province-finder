<?php
namespace Henrotaym\LaravelBelgianProvinceFinder\Contracts\Factories\Provinces;

use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces\PostcodeIntervalContract;

interface PostcodeIntervalFactoryContract
{
    /**
     * Creating a postcode interval based on given details.
     * 
     * @param array $data
     * @return PostcodeIntervalContract
     */
    public function create(array $data): PostcodeIntervalContract;
}