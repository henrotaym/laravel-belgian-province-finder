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

    public function getEnvironmentSetUp($app): void
    {
        app()->make(CreateClientsTable::class)->up();
    }

    public function test_factory_is_working()
    {
        Client::factory()->create();
        $this->assertEquals(1, DB::table('clients')->count());
    }

    public function test_scope_is_including_clients_matching_given_province()
    {
        $client = Client::factory()->create(['address' => ['postcode' => 2000]]);
        $province = $this->newProvinceRepository()->findByKey(ProvinceKey::ANTWERP);

        $this->assertEquals(
            $client->id,
            Client::whereProvinceIs($province)->first()?->id
        );
    }

    public function test_scope_is_excluding_clients_not_matching_given_province()
    {
        Client::factory()->create(['address' => ['postcode' => 6000]]);
        $province = $this->newProvinceRepository()->findByKey(ProvinceKey::ANTWERP);

        $this->assertEquals(0, Client::whereProvinceIs($province)->count());
    }

    public function test_getting_province_based_on_postcode_column()
    {
        $client = Client::factory()->create(['address' => ['postcode' => 2000]]);
        $province = $this->newProvinceRepository()->findByKey(ProvinceKey::ANTWERP);

        $this->assertEquals($province->getKey(), $client->getProvinceByPostcode()->getKey());
    }

    public function test_getting_province_based_on_postcode_column_returning_null_if_not_found()
    {
        $client = Client::factory()->create(['address' => ['postcode' => 123456789]]);

        $this->assertNull($client->getProvinceByPostcode());
    }

    public function test_getting_province_based_on_postcode_column_returning_null_if_no_postcode()
    {
        $client = Client::factory()->create(['address' => ['postcode' => null]]);

        $this->assertNull($client->getProvinceByPostcode());
    }

    protected function newProvinceRepository(): ProvinceRepositoryContract
    {
        return app()->make(ProvinceRepositoryContract::class);
    }
}
