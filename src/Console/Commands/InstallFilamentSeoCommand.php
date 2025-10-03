<?php

namespace LaravelSeoPro\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallFilamentSeoCommand extends Command
{
    protected $signature = 'seo:install-filament 
                            {--force : Overwrite existing files}';

    protected $description = 'Install Laravel SEO Pro Filament components';

    public function handle()
    {
        $this->info('Installing Laravel SEO Pro Filament components...');

        // Check if Filament is installed
        if (!class_exists('Filament\\FilamentServiceProvider')) {
            $this->error('Filament is not installed. Please install Filament first:');
            $this->line('composer require filament/filament');
            return 1;
        }

        // Publish config
        $this->call('vendor:publish', [
            '--tag' => 'seo-config',
            '--force' => $this->option('force'),
        ]);

        // Publish migrations
        $this->call('vendor:publish', [
            '--tag' => 'seo-migrations',
            '--force' => $this->option('force'),
        ]);

        // Publish views
        $this->call('vendor:publish', [
            '--tag' => 'seo-views',
            '--force' => $this->option('force'),
        ]);

        // Run migrations
        if ($this->confirm('Run database migrations?', true)) {
            $this->call('migrate');
        }

        // Generate robots.txt and sitemap
        if ($this->confirm('Generate initial robots.txt and sitemap?', true)) {
            $this->call('seo:generate-robots');
            $this->call('seo:generate-sitemap');
        }

        $this->info('Laravel SEO Pro Filament components installed successfully!');
        $this->line('');
        $this->line('Next steps:');
        $this->line('1. Visit your Filament admin panel');
        $this->line('2. Navigate to the SEO section');
        $this->line('3. Configure your SEO settings');
        $this->line('4. Start adding SEO meta to your models');

        return 0;
    }
}
