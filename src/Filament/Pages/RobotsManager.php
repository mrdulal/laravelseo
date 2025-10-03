<?php

namespace LaravelSeoPro\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use LaravelSeoPro\Services\SeoService;

class RobotsManager extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    
    protected static ?string $navigationGroup = 'SEO';
    
    protected static ?int $navigationSort = 3;
    
    protected static string $view = 'seo::filament.pages.robots-manager';
    
    protected static ?string $title = 'Robots.txt Manager';
    
    protected static ?string $slug = 'robots-manager';

    public function generateRobots(): void
    {
        try {
            $seoService = app(SeoService::class);
            $robots = $seoService->generateRobots();
            
            Notification::make()
                ->title('Robots.txt Generated')
                ->body('Your robots.txt file has been successfully generated.')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error')
                ->body('Failed to generate robots.txt: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function previewRobots(): void
    {
        $this->redirect('/seo/robots.txt');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate')
                ->label('Generate Robots.txt')
                ->icon('heroicon-o-arrow-path')
                ->action('generateRobots')
                ->color('primary'),
            
            Action::make('preview')
                ->label('Preview Robots.txt')
                ->icon('heroicon-o-eye')
                ->action('previewRobots')
                ->color('gray')
                ->openUrlInNewTab(),
        ];
    }
}
