<?php

namespace Bayurifkialghifari\WaxumApi;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WaxumApiServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('waxum')
            ->hasConfigFile('waxum');
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(WaxumApiClient::class, function ($app) {
            return new WaxumApiClient(
                baseUrl: config('waxum.base_url', 'http://localhost:3451'),
                token: config('waxum.token'),
            );
        });

        $this->app->alias(WaxumApiClient::class, 'waxum');
    }
}
