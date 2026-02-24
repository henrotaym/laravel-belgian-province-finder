# laravel-belgian-province-finder

## Compatibility

| Laravel | Package |
|---|---|
| 9.x | 1.x |
| 12.x | 2.x |

## Installation

```shell
composer require henrotaym/laravel-belgian-province-finder
```

## Usage
```php
use Henrotaym\LaravelBelgianProvinceFinder\Models\Provinces\ProvinceKey;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Repositories\Provinces\ProvinceRepositoryContract;

$repository = app()->make(ProvinceRepositoryContract::class); // ProvinceRepositoryContract
$liegeProvince = $repository->findByPostcode(4000); // ?ProvinceContract
$westFlandersProvince = $repository->findByKey(ProvinceKey::WEST_FLANDERS); // ?ProvinceContract
$provinces = $repository->getAll(); // Collection<int, ProvinceContract>
```

## Province related model
### Configure your model with trait and interface
```php
use Illuminate\Database\Eloquent\Model;
use Henrotaym\LaravelBelgianProvinceFinder\Models\Scopes\IsProvinceRelatedModel;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\IsProvinceRelatedModelContract;

class MyModel extends Model implements IsProvinceRelatedModelContract
{
    use IsProvinceRelatedModel;

    public function getProvincePostcodeColumn(): string
    {
        return "address->postcode";
    }

    public function getProvincePostcodeValue(): ?int
    {
        return $this->address['postcode'] ?? null;
    }
}
```

### Usage
```php
$models = MyModel::query()->whereProvinceIs($province)->get(); // Collection<int, MyModel>
MyModel::find(23)->getProvinceByPostcode() // ProvinceContract
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
     * Finding province based on given postcode.
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
     * Getting related postcode intervals.
     * 
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
     * Telling if given postcode is included in postcode range.
     * 
     * @param int $postcode
     * @return bool
     */
    public function isPostcodeIncluded(int $postcode): bool;
}
```
### ProvinceKey
```php
enum ProvinceKey: string
{
    case WEST_FLANDERS = "west-flanders";
    case EAST_FLANDERS = "east-flanders";
    case ANTWERP = "antwerp";
    case LIMBURG = "limburg";
    case FLEMISH_BRABANT = "flemish-brabant";
    case BRUSSELS_CAPITAL_REGION = "brussels-capital-region";
    case WALLOON_BRABANT = "walloon-brabant";
    case HAINAUT = "hainaut";
    case NAMUR = "namur";
    case LIEGE = "liege";
    case LUXEMBOURG = "luxembourg";
}
```
### IsProvinceRelatedModel
```php
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces\ProvinceContract;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces\PostcodeIntervalContract;

interface IsProvinceRelatedModel
{
    /**
     * Limiting models to those matching given province.
     * 
     * @param Builder $query
     * @param ProvinceContract $province
     * @param string $postcodeColumn
     * @return Builder
     */
    public function scopeWhereProvinceIs(Builder $query, ProvinceContract $province, ?string $postcodeColumn = null): Builder;

    /**
     * Limiting models to those matching given postcode intervals.
     * 
     * @param Builder $query
     * @param Collection<int, PostcodeIntervalContract> $postcodeIntervals
     * @param string $postcodeColumn
     * @return Builder
     */
    public function scopeInPostcodeIntervals(Builder $query, Collection $postcodeIntervals, ?string $postcodeColumn = null): Builder;

     /**
     * Limiting models to those matching given postcode interval.
     * 
     * @param Builder $query
     * @param PostcodeIntervalContract $postcodeInterval
     * @param string $postcodeColumn
     * @return Builder
     */
    public function scopeInPostcodeInterval(Builder $query, PostcodeIntervalContract $postcodeInterval, ?string $postcodeColumn = null): Builder;

    /**
     * Getting related province using postcode column.
     * 
     * @return ?ProvinceContract
     */
    public function getProvinceByPostcode(): ?ProvinceContract;
}
```