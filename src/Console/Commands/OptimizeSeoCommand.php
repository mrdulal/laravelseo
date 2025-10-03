<?php

namespace LaravelSeoPro\Console\Commands;

use Illuminate\Console\Command;
use LaravelSeoPro\Services\SeoService;
use LaravelSeoPro\Models\SeoMeta;
use Illuminate\Support\Facades\DB;

class OptimizeSeoCommand extends Command
{
    protected $signature = 'seo:optimize 
                            {--model= : Specific model to optimize}
                            {--all : Optimize all models}
                            {--score : Show SEO scores}
                            {--recommendations : Show recommendations}';

    protected $description = 'Optimize SEO data for models';

    public function handle()
    {
        $this->info('🚀 Starting SEO optimization...');

        if ($this->option('all')) {
            $this->optimizeAllModels();
        } elseif ($model = $this->option('model')) {
            $this->optimizeModel($model);
        } else {
            $this->optimizeSeoMetaRecords();
        }

        $this->info('✅ SEO optimization completed!');
    }

    protected function optimizeAllModels()
    {
        $this->info('Optimizing all models with HasSeo trait...');

        $models = $this->getModelsWithHasSeoTrait();
        
        foreach ($models as $modelClass) {
            $this->info("Processing {$modelClass}...");
            
            $model = new $modelClass;
            $count = $model->count();
            
            if ($count > 0) {
                $bar = $this->output->createProgressBar($count);
                $bar->start();
                
                $model->chunk(100, function ($items) use ($bar) {
                    foreach ($items as $item) {
                        $item->optimizeSeo();
                        $bar->advance();
                    }
                });
                
                $bar->finish();
                $this->newLine();
            }
        }
    }

    protected function optimizeModel(string $modelClass)
    {
        if (!class_exists($modelClass)) {
            $this->error("Model {$modelClass} not found!");
            return;
        }

        if (!in_array(\LaravelSeoPro\Traits\HasSeo::class, class_uses($modelClass))) {
            $this->error("Model {$modelClass} does not use HasSeo trait!");
            return;
        }

        $this->info("Optimizing {$modelClass}...");
        
        $model = new $modelClass;
        $count = $model->count();
        
        if ($count > 0) {
            $bar = $this->output->createProgressBar($count);
            $bar->start();
            
            $model->chunk(100, function ($items) use ($bar) {
                foreach ($items as $item) {
                    $item->optimizeSeo();
                    $bar->advance();
                }
            });
            
            $bar->finish();
            $this->newLine();
        }
    }

    protected function optimizeSeoMetaRecords()
    {
        $this->info('Optimizing SEO meta records...');
        
        $count = SeoMeta::count();
        
        if ($count > 0) {
            $bar = $this->output->createProgressBar($count);
            $bar->start();
            
            SeoMeta::chunk(100, function ($records) use ($bar) {
                foreach ($records as $record) {
                    $this->optimizeSeoMetaRecord($record);
                    $bar->advance();
                }
            });
            
            $bar->finish();
            $this->newLine();
        }
    }

    protected function optimizeSeoMetaRecord(SeoMeta $record)
    {
        $seoService = app(SeoService::class);
        
        // Load data from record
        $seoService->setTitle($record->title ?? '')
                  ->setDescription($record->description ?? '')
                  ->setKeywords($record->keywords ?? '');
        
        // Optimize
        $optimized = $seoService->optimize();
        
        // Update record with optimized data
        $record->update([
            'title' => $optimized->getTitle(),
            'description' => $optimized->getDescription(),
            'keywords' => $optimized->getKeywords(),
        ]);
    }

    protected function getModelsWithHasSeoTrait(): array
    {
        $models = [];
        $appPath = app_path('Models');
        
        if (is_dir($appPath)) {
            $files = glob($appPath . '/*.php');
            
            foreach ($files as $file) {
                $className = 'App\\Models\\' . basename($file, '.php');
                
                if (class_exists($className) && 
                    in_array(\LaravelSeoPro\Traits\HasSeo::class, class_uses($className))) {
                    $models[] = $className;
                }
            }
        }
        
        return $models;
    }

    protected function showSeoScores()
    {
        $this->info('SEO Scores:');
        
        $seoService = app(SeoService::class);
        
        SeoMeta::chunk(50, function ($records) use ($seoService) {
            foreach ($records as $record) {
                $seoService->loadFromModel($record->seoable);
                $score = $seoService->getSeoScore();
                
                $this->line("Model: {$record->seoable_type} ID: {$record->seoable_id} - Score: {$score}/100");
            }
        });
    }

    protected function showRecommendations()
    {
        $this->info('SEO Recommendations:');
        
        $seoService = app(SeoService::class);
        
        SeoMeta::chunk(50, function ($records) use ($seoService) {
            foreach ($records as $record) {
                $seoService->loadFromModel($record->seoable);
                $recommendations = $seoService->getRecommendations();
                
                if (!empty($recommendations)) {
                    $this->line("Model: {$record->seoable_type} ID: {$record->seoable_id}");
                    foreach ($recommendations as $recommendation) {
                        $this->line("  - {$recommendation}");
                    }
                    $this->newLine();
                }
            }
        });
    }
}
