<?php
namespace Henrotaym\LaravelBelgianProvinceFinder\Repositories;

use Illuminate\Support\Collection;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces\ProvinceContract;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Factories\Provinces\ProvinceFactoryContract;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Repositories\Provinces\ProvinceRepositoryContract;
use Henrotaym\LaravelBelgianProvinceFinder\Models\Provinces\ProvinceKey;

class ProvinceRepository implements ProvinceRepositoryContract
{
    /**
     * @var Collection<int, ProvinceContract>
     */
    protected Collection $provinces;

    public function __construct(
        protected ProvinceFactoryContract $provinceFactory
    ){
        
    }

    public function findByKey(ProvinceKey $key): ?ProvinceContract
    {
        return $this->getAll()->first(
            fn (ProvinceContract $province): bool => $province->getKey() === $key
        );
    }

    public function findByPostcode(int $postcode): ?ProvinceContract
    {
        return $this->getAll()->first(
            fn (ProvinceContract $province): bool => $province->isPostcodeIncluded($postcode)
        );
    }
    
    public function getAll(): Collection
    {
        return $this->provinces ??
            $this->provinces = $this->getProvincesFromFactory();
    }

    /**
     * Getting provinces directly from factory.
     * 
     * @return Collection<int, ProvinceContract>
     */
    protected function getProvincesFromFactory(): Collection
    {
        return collect($this->data)->map(
            fn (array $data) => $this->provinceFactory->create($data)
        );
    }

    protected array $data = [
        [
            "key" => ProvinceKey::BRUSSELS_CAPITAL_REGION,
            'intervals' => [
                ['start' => 1000, 'end' => 1300],
            ]
        ],
        [
            "key" => ProvinceKey::WALLOON_BRABANT,
            'intervals' => [
                ['start' => 1300, 'end' => 1500],
            ]
        ],
        [
            "key" => ProvinceKey::FLEMISH_BRABANT,
            'intervals' => [
                ['start' => 1500, 'end' => 2000],
                ['start' => 3000, 'end' => 3500],
            ]
        ],
        [
            "key" => ProvinceKey::ANTWERP,
            'intervals' => [
                ['start' => 2000, 'end' => 3000],
            ]
        ],
        [
            "key" => ProvinceKey::LIMBURG,
            'intervals' => [
                ['start' => 3500, 'end' => 4000],
            ]
        ],
        [
            "key" => ProvinceKey::LIEGE,
            'intervals' => [
                ['start' => 4000, 'end' => 5000],
            ]
        ],
        [
            "key" => ProvinceKey::NAMUR,
            'intervals' => [
                ['start' => 5000, 'end' => 6000],
            ]
        ],
        [
            "key" => ProvinceKey::HAINAUT,
            'intervals' => [
                ['start' => 6000, 'end' => 6600],
                ['start' => 7000, 'end' => 8000],
            ]
        ],
        [
            "key" => ProvinceKey::LUXEMBOURG,
            'intervals' => [
                ['start' => 6600, 'end' => 7000],
            ]
        ],
        [
            "key" => ProvinceKey::WEST_FLANDERS,
            'intervals' => [
                ['start' => 8000, 'end' => 9000],
            ]
        ],
        [
            "key" => ProvinceKey::EAST_FLANDERS,
            'intervals' => [
                ['start' => 9000, 'end' => 10000],
            ]
        ],
    ];
}