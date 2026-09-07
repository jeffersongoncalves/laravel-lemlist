<?php

namespace JeffersonGoncalves\Lemlist;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LemlistServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('lemlist')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(Lemlist::class, function () {
            return new Lemlist(
                (string) config('lemlist.api_key'),
                (string) config('lemlist.base_url'),
            );
        });
    }
}
