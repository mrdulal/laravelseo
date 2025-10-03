<?php

namespace LaravelSeoPro\Tests\Feature;

use LaravelSeoPro\Tests\TestCase;

class BasicTest extends TestCase
{

    public function test_package_can_be_loaded()
    {
        $this->assertTrue(true);
    }

    public function test_seo_service_is_registered()
    {
        $this->assertTrue($this->app->bound('seo'));
    }

    public function test_config_is_loaded()
    {
        $this->assertNotNull(config('seo'));
        $this->assertIsArray(config('seo'));
    }
}
