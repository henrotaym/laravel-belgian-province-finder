<?php
namespace Henrotaym\LaravelBelgianProvinceFinder\Models\Scopes;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces\ProvinceContract;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces\PostcodeIntervalContract;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Repositories\Provinces\ProvinceRepositoryContract;

/** */
trait IsProvinceRelatedModel
{
    /**
     * Limiting models to those matching given province.
     * 
     * @param Builder $query
     * @param ProvinceContract $province
     * @return Builder
     */
    public function scopeWhereProvinceIs(Builder $query, ProvinceContract $province): Builder
    {
        return $query->where(function (Builder $query) use ($province) {
            return $query->inPostcodeIntervals($province->getPostcodeIntervals());
        });
    }

    /**
     * Limiting models to those matching given postcode intervals.
     * 
     * @param Builder $query
     * @param Collection<int, PostcodeIntervalContract> $postcodeIntervals
     * @return Builder
     */
    public function scopeInPostcodeIntervals(Builder $query, Collection $postcodeIntervals): Builder
    {
        $postcodeIntervals->each(fn (PostcodeIntervalContract $postcode) => 
            $query->orWhere(function (Builder $query) use ($postcode) {
                return $query->inPostcodeInterval($postcode);
            })
        );

        return $query;
    }

     /**
     * Limiting models to those matching given postcode interval.
     * 
     * @param Builder $query
     * @param PostcodeIntervalContract $postcodeInterval
     * @return Builder
     */
    public function scopeInPostcodeInterval(Builder $query, PostcodeIntervalContract $postcodeInterval): Builder
    {
        return $query->where($this->getProvincePostcodeColumn(), ">=", $postcodeInterval->getStart())
            ->where($this->getProvincePostcodeColumn(), "<", $postcodeInterval->getEnd());
    }

    /**
     * Getting related province using postcode column.
     * 
     * @return ?ProvinceContract
     */
    public function getProvinceByPostcode(): ?ProvinceContract
    {
        if (!$postcode = $this->getProvincePostcodeValue()) return null;

        /** @var ProvinceRepositoryContract */
        $repository = app()->make(ProvinceRepositoryContract::class);

        return $repository->findByPostcode($postcode);
    }
}