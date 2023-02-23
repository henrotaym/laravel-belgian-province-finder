<?php
namespace Henrotaym\LaravelBelgianProvinceFinder\Tests\Factories\Models;

use Faker\Factory as FakerFactory;
use Henrotaym\LaravelBelgianProvinceFinder\Tests\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory as EloquentFactory;

class ClientFactory extends EloquentFactory
{
    protected $model = Client::class;

    public function definition()
    {
        $faker = FakerFactory::create();

        return [
            "address" => ["postcode" => $faker->postcode()]
        ];
    }
}