<?php
namespace Henrotaym\VersioningPackageTemplate\Tests;

use Henrotaym\VersioningPackageTemplate\Package;
use Henrotaym\LaravelPackageVersioning\Testing\VersionablePackageTestCase;
use Henrotaym\VersioningPackageTemplate\Providers\VersioningPackageTemplateServiceProvider;

class TestCase extends VersionablePackageTestCase
{
    public static function getPackageClass(): string
    {
        return Package::class;
    }
    
    public function getServiceProviders(): array
    {
        return [
            VersioningPackageTemplateServiceProvider::class
        ];
    }
}