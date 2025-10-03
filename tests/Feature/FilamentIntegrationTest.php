<?php

namespace LaravelSeoPro\Tests\Feature;

use LaravelSeoPro\Tests\TestCase;

class FilamentIntegrationTest extends TestCase
{
    public function test_filament_classes_exist()
    {
        // Test that Filament integration classes exist (skip if Filament not installed)
        if (class_exists('Filament\PluginServiceProvider')) {
            $this->assertTrue(class_exists(\LaravelSeoPro\Filament\SeoProPlugin::class));
        }
        
        // Test that our Filament integration files exist
        $this->assertTrue(file_exists(__DIR__ . '/../../src/Filament/Resources/SeoMetaResource.php'));
        $this->assertTrue(file_exists(__DIR__ . '/../../src/Filament/Pages/SeoDashboard.php'));
        $this->assertTrue(file_exists(__DIR__ . '/../../src/Filament/Pages/SitemapManager.php'));
        $this->assertTrue(file_exists(__DIR__ . '/../../src/Filament/Pages/RobotsManager.php'));
        $this->assertTrue(file_exists(__DIR__ . '/../../src/Filament/Widgets/SeoOverviewWidget.php'));
        $this->assertTrue(file_exists(__DIR__ . '/../../src/Filament/Widgets/SeoAuditWidget.php'));
        $this->assertTrue(file_exists(__DIR__ . '/../../src/Filament/Widgets/SeoPerformanceWidget.php'));
        $this->assertTrue(file_exists(__DIR__ . '/../../src/Filament/Components/SeoFields.php'));
    }

    public function test_filament_views_exist()
    {
        // Test that Filament views exist
        $this->assertTrue(file_exists(__DIR__ . '/../../resources/views/filament/pages/seo-dashboard.blade.php'));
        $this->assertTrue(file_exists(__DIR__ . '/../../resources/views/filament/pages/sitemap-manager.blade.php'));
        $this->assertTrue(file_exists(__DIR__ . '/../../resources/views/filament/pages/robots-manager.blade.php'));
    }

    public function test_filament_installation_command_exists()
    {
        $this->assertTrue(class_exists(\LaravelSeoPro\Console\Commands\InstallFilamentSeoCommand::class));
    }

    public function test_service_provider_registers_filament_plugin()
    {
        $provider = new \LaravelSeoPro\Providers\SeoProServiceProvider(app());
        
        // Test that the provider has the Filament plugin registration method
        $this->assertTrue(method_exists($provider, 'registerFilamentPlugin'));
    }
}
