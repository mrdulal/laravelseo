<?php

namespace LaravelSeoPro\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AttachSeoCommand extends Command
{
    protected $signature = 'seo:attach {model : The model class to attach SEO to}';
    protected $description = 'Attach SEO functionality to a model';

    public function handle()
    {
        $modelClass = $this->argument('model');
        
        if (!class_exists($modelClass)) {
            $this->error("Model class '{$modelClass}' not found.");
            return 1;
        }

        $modelPath = $this->getModelPath($modelClass);
        
        if (!$modelPath || !File::exists($modelPath)) {
            $this->error("Could not find model file for '{$modelClass}'.");
            return 1;
        }

        $content = File::get($modelPath);
        
        // Check if HasSeo trait is already imported
        if (str_contains($content, 'use LaravelSeoPro\\Traits\\HasSeo;')) {
            $this->info('HasSeo trait is already attached to this model.');
            return 0;
        }

        // Add the trait import
        $content = $this->addTraitImport($content);
        
        // Add the trait to the class
        $content = $this->addTraitToClass($content);

        File::put($modelPath, $content);

        $this->info("Successfully attached HasSeo trait to {$modelClass}.");
        $this->line("Don't forget to run 'php artisan migrate' to create the seo_meta table.");
        
        return 0;
    }

    protected function getModelPath(string $modelClass): ?string
    {
        $reflection = new \ReflectionClass($modelClass);
        return $reflection->getFileName();
    }

    protected function addTraitImport(string $content): string
    {
        $import = "use LaravelSeoPro\\Traits\\HasSeo;\n";
        
        // Find the last use statement
        preg_match_all('/^use [^;]+;$/m', $content, $matches, PREG_OFFSET_CAPTURE);
        
        if (empty($matches[0])) {
            // No use statements found, add after opening PHP tag
            $content = preg_replace('/^<\?php\n/', "<?php\n{$import}", $content);
        } else {
            // Add after the last use statement
            $lastUse = end($matches[0]);
            $position = $lastUse[1] + strlen($lastUse[0]);
            $content = substr_replace($content, "\n{$import}", $position, 0);
        }
        
        return $content;
    }

    protected function addTraitToClass(string $content): string
    {
        // Find the class declaration
        preg_match('/class\s+\w+.*?\{/', $content, $matches, PREG_OFFSET_CAPTURE);
        
        if (empty($matches)) {
            return $content;
        }
        
        $classDeclaration = $matches[0][0];
        $position = $matches[0][1] + strlen($classDeclaration);
        
        // Add the trait
        $trait = "    use HasSeo;\n\n";
        $content = substr_replace($content, $trait, $position, 0);
        
        return $content;
    }
}
