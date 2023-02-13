<?php
namespace Henrotaym\LaravelBelgianProvinceFinder\Tests;

use Henrotaym\LaravelBelgianProvinceFinder\Package;
use Henrotaym\LaravelPackageVersioning\Testing\VersionablePackageTestCase;
use Henrotaym\LaravelBelgianProvinceFinder\Providers\LaravelBelgianProvinceFinderServiceProvider;

class TestCase extends VersionablePackageTestCase
{
    public static function getPackageClass(): string
    {
        return Package::class;
    }
    
    public function getServiceProviders(): array
    {
        return [
            LaravelBelgianProvinceFinderServiceProvider::class
        ];
    }
}