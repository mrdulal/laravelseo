<?php

namespace LaravelSeoPro\Filament\Pages;

use Filament\Pages\Page;
use LaravelSeoPro\Filament\Widgets\SeoOverviewWidget;
use LaravelSeoPro\Filament\Widgets\SeoAuditWidget;
use LaravelSeoPro\Filament\Widgets\SeoPerformanceWidget;

class SeoDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    
    protected static ?string $navigationGroup = 'SEO';
    
    protected static ?int $navigationSort = 0;
    
    protected static string $view = 'seo::filament.pages.seo-dashboard';
    
    protected static ?string $title = 'SEO Dashboard';
    
    protected static ?string $slug = 'seo-dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            SeoOverviewWidget::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            SeoAuditWidget::class,
            SeoPerformanceWidget::class,
        ];
    }
}
