<?php

namespace LaravelSeoPro\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use LaravelSeoPro\Facades\Seo;

class GenerateRobotsCommand extends Command
{
    protected $signature = 'seo:generate-robots {--path=public/robots.txt : Path to save robots.txt file}';
    protected $description = 'Generate robots.txt file';

    public function handle()
    {
        $path = $this->option('path');
        $content = Seo::generateRobots();

        File::put($path, $content);

        $this->info("Robots.txt generated successfully at: {$path}");
    }
}
