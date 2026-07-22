<?php

namespace Bayurifkialghifari\WaxumApi\Tests;

use Bayurifkialghifari\WaxumApi\WaxumApiServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            WaxumApiServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
        config()->set('waxum.base_url', 'http://localhost:3451');
        config()->set('waxum.token', 'test-token');
    }
}
