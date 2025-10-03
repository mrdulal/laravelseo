<?php

namespace LaravelSeoPro\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \LaravelSeoPro\Providers\SeoProServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Package doesn't require database configuration
        // SEO functionality works without database connections
    }
}
