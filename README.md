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

## Province related model
### Add trait to your model
```php
use Illuminate\Database\Eloquent\Model;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Scopes\IsRelatedToProvince;

class MyModel extends Model
{
    use IsRelatedToProvince;
}
```

### Usage
```php
MyModel::query()->whereProvinceIs($province, "postal_code")->first();
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
### IsRelatedToProvince
```php
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
```