<?php

namespace LaravelSeoPro\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use LaravelSeoPro\Facades\Seo;

class GenerateSitemapCommand extends Command
{
    protected $signature = 'seo:generate-sitemap {--path=public/sitemap.xml : Path to save sitemap.xml file}';
    protected $description = 'Generate XML sitemap file';

    public function handle()
    {
        $path = $this->option('path');
        $content = Seo::generateSitemap();

        File::put($path, $content);

        $this->info("Sitemap.xml generated successfully at: {$path}");
    }
}
