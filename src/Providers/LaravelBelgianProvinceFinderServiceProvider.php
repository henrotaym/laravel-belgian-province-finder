<?php
namespace Henrotaym\LaravelBelgianProvinceFinder\Providers;

use Henrotaym\LaravelBelgianProvinceFinder\Package;
use Henrotaym\LaravelBelgianProvinceFinder\Models\Provinces\Province;
use Henrotaym\LaravelBelgianProvinceFinder\Models\Provinces\PostcodeInterval;
use Henrotaym\LaravelBelgianProvinceFinder\Factories\Provinces\ProvinceFactory;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces\ProvinceContract;
use Henrotaym\LaravelBelgianProvinceFinder\Factories\Provinces\PostcodeIntervalFactory;
use Henrotaym\LaravelPackageVersioning\Providers\Abstracts\VersionablePackageServiceProvider;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces\PostcodeIntervalContract;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Factories\Provinces\ProvinceFactoryContract;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Factories\Provinces\PostcodeIntervalFactoryContract;
use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Repositories\Provinces\ProvinceRepositoryContract;
use Henrotaym\LaravelBelgianProvinceFinder\Repositories\ProvinceRepository;

class LaravelBelgianProvinceFinderServiceProvider extends VersionablePackageServiceProvider
{
    public static function getPackageClass(): string
    {
        return Package::class;
    }

    protected function addToRegister(): void
    {
        $this->app->bind(PostcodeIntervalFactoryContract::class, PostcodeIntervalFactory::class);
        $this->app->bind(ProvinceFactoryContract::class, ProvinceFactory::class);
        $this->app->bind(PostcodeIntervalContract::class, PostcodeInterval::class);
        $this->app->bind(ProvinceContract::class, Province::class);
        $this->app->bind(ProvinceRepositoryContract::class, ProvinceRepository::class);
    }

    protected function addToBoot(): void
    {
        //
    }
}