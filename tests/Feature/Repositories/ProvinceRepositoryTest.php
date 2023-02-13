<?php
namespace Henrotaym\LaravelBelgianProvinceFinder\Tests\Feature\Repositories;

use Henrotaym\LaravelBelgianProvinceFinder\Models\Provinces\ProvinceKey;
use Henrotaym\LaravelBelgianProvinceFinder\Repositories\ProvinceRepository;
use Henrotaym\LaravelBelgianProvinceFinder\Tests\TestCase;

class ProvinceRepositoryTest extends TestCase
{
    public function test_getting_all_provinces_defined()
    {
        $this->assertCount(
            count(ProvinceKey::cases()),
            $this->newProvinceRepository()->getAll()
        );
    }

    public function test_getting_province_by_key_returning_province_if_matching_key()
    {
        $this->assertEquals(
            ProvinceKey::FLEMISH_BRABANT,
            $this->newProvinceRepository()->findByKey(ProvinceKey::FLEMISH_BRABANT)
                ->getKey()
        );
    }

    public function test_getting_province_by_postcode_if_matching_start()
    {
        $this->assertEquals(
            ProvinceKey::FLEMISH_BRABANT,
            $this->newProvinceRepository()->findByPostcode(1500)
                ->getKey()
        );
    }

    public function test_getting_province_by_postcode_if_in_range()
    {
        $this->assertEquals(
            ProvinceKey::FLEMISH_BRABANT,
            $this->newProvinceRepository()->findByPostcode(1600)
                ->getKey()
        );
    }

    public function test_getting_province_by_postcode_returning_next_if_matching_end_exactly()
    {
        $this->assertEquals(
            ProvinceKey::ANTWERP,
            $this->newProvinceRepository()->findByPostcode(2000)->getKey()
        );
    }

    public function test_getting_province_by_postcode_if_matching_second_start()
    {
        $this->assertEquals(
            ProvinceKey::FLEMISH_BRABANT,
            $this->newProvinceRepository()->findByPostcode(3000)
                ->getKey()
        );
    }

    public function test_getting_province_by_postcode_if_in_second_range()
    {
        $this->assertEquals(
            ProvinceKey::FLEMISH_BRABANT,
            $this->newProvinceRepository()->findByPostcode(3200)
                ->getKey()
        );
    }

    public function test_getting_province_by_postcode_returning_next_if_matching_second_end_exactly()
    {
        $this->assertEquals(
            ProvinceKey::LIMBURG,
            $this->newProvinceRepository()->findByPostcode(3500)->getKey()
        );
    }

    public function test_getting_province_by_postcode_returning_null_if_after_range()
    {
        $this->assertNull(
            $this->newProvinceRepository()->findByPostcode(11000)
        );
    }

    public function test_getting_province_by_postcode_returning_null_if_before_range()
    {
        $this->assertNull(
            $this->newProvinceRepository()->findByPostcode(900)
        );
    }

    protected function newProvinceRepository(): ProvinceRepository
    {
        return app()->make(ProvinceRepository::class);
    }
}