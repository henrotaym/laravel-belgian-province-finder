<?php
namespace Henrotaym\LaravelBelgianProvinceFinder\Factories\Provinces;

use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Factories\Provinces\PostcodeIntervalFactoryContract;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces\PostcodeIntervalContract;

class PostcodeIntervalFactory implements PostcodeIntervalFactoryContract
{
    public function create(array $data): PostcodeIntervalContract
    {
        return app()->make(PostcodeIntervalContract::class, [
            "start" => $data["start"],
            "end" => $data["end"]
        ]);
    }
}