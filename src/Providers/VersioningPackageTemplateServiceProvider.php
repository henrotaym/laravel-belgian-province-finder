<?php
namespace Henrotaym\VersioningPackageTemplate\Providers;

use Henrotaym\VersioningPackageTemplate\Package;
use Henrotaym\LaravelPackageVersioning\Providers\Abstracts\VersionablePackageServiceProvider;

class VersioningPackageTemplateServiceProvider extends VersionablePackageServiceProvider
{
    public static function getPackageClass(): string
    {
        return Package::class;
    }

    protected function addToRegister(): void
    {
        //
    }

    protected function addToBoot(): void
    {
        //
    }
}