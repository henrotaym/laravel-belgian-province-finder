<?php
namespace Henrotaym\LaravelBelgianProvinceFinder\Tests\Models;

use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\IsProvinceRelatedModelContract;
use Henrotaym\LaravelBelgianProvinceFinder\Models\Scopes\IsProvinceRelatedModel;
use Henrotaym\LaravelBelgianProvinceFinder\Tests\Factories\Models\ClientFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model implements IsProvinceRelatedModelContract
{
    use HasFactory, IsProvinceRelatedModel;

    protected $fillable = ["address"];
    protected $casts = ['address' => 'array'];

    protected static function newFactory()
    {
        return ClientFactory::new();
    }

    public function getProvincePostcodeColumn(): string
    {
        return "address->postcode";
    }

    public function getProvincePostcodeValue(): ?int
    {
        return $this->address['postcode'] ?? null;
    }
}