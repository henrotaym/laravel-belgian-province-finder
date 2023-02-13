<?php
namespace Henrotaym\LaravelBelgianProvinceFinder\Factories\Provinces;

use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Factories\Provinces\PostcodeIntervalFactoryContract;
use Illuminate\Support\Str;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces\ProvinceContract;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Factories\Provinces\ProvinceFactoryContract;

class ProvinceFactory implements ProvinceFactoryContract
{
    public function __construct(
        protected PostcodeIntervalFactoryContract $intervalFactory
    ) {
        
    }

    public function create(array $data): ProvinceContract
    {
        return app()->make(ProvinceContract::class, [
            "name" => $data["name"] ?? Str::headline($data["key"]->value),
            "key" => $data["key"],
            "intervals" => collect($data["intervals"])
                ->map(fn (array $interval) =>
                    $this->intervalFactory->create($interval)
                )
        ]);
    }
}