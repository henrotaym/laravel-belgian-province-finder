<?php
namespace Henrotaym\LaravelBelgianProvinceFinder\Models\Provinces;

use Illuminate\Support\Collection;
use Henrotaym\LaravelBelgianProvinceFinder\Models\Provinces\ProvinceKey;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces\ProvinceContract;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces\PostcodeIntervalContract;

class Province implements ProvinceContract
{
    /**
     * Building instance.
     * 
     * @param string $name Province name.
     * @param ProvinceKey $key Province unique key.
     * @param Collection<int, PostcodeIntervalContract> $intervals Postcode intervals matching province.
     */
    public function __construct(
        protected string $name, 
        protected ProvinceKey $key,
        protected Collection $intervals
    ) {

    }

    public function getPostCodeIntervals(): Collection
    {
        return $this->intervals;
    }

    public function getKey(): ProvinceKey
    {
        return $this->key;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isPostcodeIncluded(int $postcode): bool
    {
        return $this->getPostCodeIntervals()->contains(
            fn (PostcodeIntervalContract $interval) => $interval->isPostcodeIncluded($postcode)
        );
    }
}