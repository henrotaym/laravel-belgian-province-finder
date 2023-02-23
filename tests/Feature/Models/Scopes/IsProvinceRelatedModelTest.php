<?php
namespace Henrotaym\LaravelBelgianProvinceFinder\Tests\Feature\Models\Scopes;

use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Repositories\Provinces\ProvinceRepositoryContract;
use Henrotaym\LaravelBelgianProvinceFinder\Models\Provinces\ProvinceKey;
use Henrotaym\LaravelBelgianProvinceFinder\Tests\Database\Migrations\CreateClientsTable;
use Henrotaym\LaravelBelgianProvinceFinder\Tests\Models\Client;
use Henrotaym\LaravelBelgianProvinceFinder\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class IsProvinceRelatedModelTest extends TestCase
{
    use RefreshDatabase;

    public function getEnvironmentSetUp($app)
    {
        app()->make(CreateClientsTable::class)->up();
    }

    public function test_factory_is_working()
    {
        Client::factory()->create();
        $this->assertEquals(1, DB::table('clients')->count());
    }

    public function test_client_is_limiting_to_province()
    {
        $client = Client::factory()->create(['address' => ['postcode' => 2000]]);
        $province = app()->make(ProvinceRepositoryContract::class)->findByKey(ProvinceKey::ANTWERP);
        $this->assertEquals(
            $client->id,
            Client::whereProvinceIs($province)->first()?->id
        );

        dd($client->getProvinceByPostcode());
    }
}
