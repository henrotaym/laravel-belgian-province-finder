# laravel-belgian-province-finder

## Installation

```shell
composer require henrotaym/laravel-belgian-province-finder
```

## Usage
```php
use Henrotaym\LaravelBelgianProvinceFinder\Models\Provinces\ProvinceKey;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Repositories\Provinces\ProvinceRepositoryContract;

$repository = app()->make(ProvinceRepositoryContract::class);
$liegeProvince = $repository->findByPostcode(4000);
$westFlandersProvince = $repository->findByKey(ProvinceKey::WEST_FLANDERS);
$provinces = $repository->getAll();
```

## References
### ProvinceRepository
```php
use Illuminate\Support\Collection;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces\ProvinceContract;
use Henrotaym\LaravelBelgianProvinceFinder\Models\Provinces\ProvinceKey;

interface ProvinceRepositoryContract
{
    /**
     * Getting province based on given postcode.
     * 
     * @param int $postcode
     * @return ?ProvinceContract
     */
    public function findByPostcode(int $postcode): ?ProvinceContract;

    /**
     * Finding province based on given unique key.
     * 
     * @param ProvinceKey $key
     * @return ?ProvinceContract
     */
    public function findByKey(ProvinceKey $key): ?ProvinceContract;

    /**
     * Getting all provinces.
     * 
     * @return Collection<int, ProvinceContract>
     */
    public function getAll(): Collection;
}
```

### Province
```php
use Illuminate\Support\Collection;
use Henrotaym\LaravelBelgianProvinceFinder\Models\Provinces\ProvinceKey;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces\PostcodeIntervalContract;

interface ProvinceContract
{
    /**
     * Getting province name.
     * 
     * @return string
     */
    public function getName(): string;

    /**
     * Getting province unique key.
     * 
     * @return ProvinceKey
     */
    public function getKey(): ProvinceKey;

    /**
     * @return Collection<int, PostcodeIntervalContract>
     */
    public function getPostcodeIntervals(): Collection;

    /**
     * Telling if given postcode is included in province.
     * 
     * @param int $postcode
     * @return bool
     */
    public function isPostcodeIncluded(int $postcode): bool;
}
```

### PostcodeInterval
```php
namespace Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces;

interface PostcodeIntervalContract
{
    /**
     * Getting starting interval postcode.
     * 
     * @return int
     */
    public function getStart(): int;

    /**
     * Getting ending interval postcode.
     * 
     * @return int
     */
    public function getEnd(): int;

    /**
     * Telling if given postcode is included in range.
     * 
     * @param int $postcode
     * @return bool
     */
    public function isPostcodeIncluded(int $postcode): bool;
}
```