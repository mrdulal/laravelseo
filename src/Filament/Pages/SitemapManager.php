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

class SitemapManager extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-map';
    
    protected static ?string $navigationGroup = 'SEO';
    
    protected static ?int $navigationSort = 2;
    
    protected static string $view = 'seo::filament.pages.sitemap-manager';
    
    protected static ?string $title = 'Sitemap Manager';
    
    protected static ?string $slug = 'sitemap-manager';

    public function generateSitemap(): void
    {
        try {
            $seoService = app(SeoService::class);
            $sitemap = $seoService->generateSitemap();
            
            Notification::make()
                ->title('Sitemap Generated')
                ->body('Your sitemap has been successfully generated.')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error')
                ->body('Failed to generate sitemap: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function previewSitemap(): void
    {
        $this->redirect('/seo/sitemap.xml');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate')
                ->label('Generate Sitemap')
                ->icon('heroicon-o-arrow-path')
                ->action('generateSitemap')
                ->color('primary'),
            
            Action::make('preview')
                ->label('Preview Sitemap')
                ->icon('heroicon-o-eye')
                ->action('previewSitemap')
                ->color('gray')
                ->openUrlInNewTab(),
        ];
    }
}
