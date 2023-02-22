<?php
namespace Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Scopes;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces\ProvinceContract;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces\PostcodeIntervalContract;

trait IsRelatedToProvince
{
    /**
     * Limiting models to those matching given province.
     * 
     * @param Builder $query
     * @param ProvinceContract $province
     * @param string $postcodeColumn
     * @return Builder
     */
    public function scopeWhereProvinceIs(Builder $query, ProvinceContract $province, string $postcodeColumn): Builder
    {
        return $query->where(function (Builder $query) use ($province, $postcodeColumn) {
            return $query->scopeInPostcodeIntervals($province->getPostcodeIntervals(), $postcodeColumn);
        });
    }

    /**
     * Limiting models to those matching given postcode intervals.
     * 
     * @param Builder $query
     * @param Collection<int, PostcodeIntervalContract> $postcodeIntervals
     * @param string $postcodeColumn
     * @return Builder
     */
    public function scopeInPostcodeIntervals(Builder $query, Collection $postcodeIntervals, string $postcodeColumn): Builder
    {
        $postcodeIntervals->each(fn (PostcodeIntervalContract $postcode) => 
            $query->orWhere(function (Builder $query) use ($postcode, $postcodeColumn) {
                return $query->inPostcodeInterval($postcode, $postcodeColumn);
            })
        );

        return $query;
    }

     /**
     * Limiting models to those matching given postcode interval.
     * 
     * @param Builder $query
     * @param PostcodeIntervalContract $postcodeInterval
     * @param string $postcodeColumn
     * @return Builder
     */
    public function scopeInPostcodeInterval(Builder $query, PostcodeIntervalContract $postcodeInterval, string $postcodeColumn): Builder
    {
        return $query->where($postcodeColumn, ">=", $postcodeInterval->getStart())
            ->where($postcodeColumn, "<", $postcodeInterval->getEnd());
    }
}