<?php

namespace LaravelSeoPro\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use LaravelSeoPro\Models\SeoMeta;
use Illuminate\Support\Facades\DB;

class SeoOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalSeoRecords = SeoMeta::count();
        $recordsWithTitle = SeoMeta::whereNotNull('title')->count();
        $recordsWithDescription = SeoMeta::whereNotNull('description')->count();
        $recordsWithOgTags = SeoMeta::whereNotNull('og_title')->count();
        $recordsWithTwitterTags = SeoMeta::whereNotNull('twitter_title')->count();
        
        $completionRate = $totalSeoRecords > 0 
            ? round(($recordsWithTitle + $recordsWithDescription) / ($totalSeoRecords * 2) * 100, 1)
            : 0;

        return [
            Stat::make('Total SEO Records', $totalSeoRecords)
                ->description('All SEO meta records')
                ->descriptionIcon('heroicon-m-tag')
                ->color('primary'),
            
            Stat::make('Completion Rate', $completionRate . '%')
                ->description('Basic SEO completion')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($completionRate >= 80 ? 'success' : ($completionRate >= 60 ? 'warning' : 'danger')),
            
            Stat::make('Open Graph Tags', $recordsWithOgTags)
                ->description('Records with OG tags')
                ->descriptionIcon('heroicon-m-share')
                ->color('info'),
            
            Stat::make('Twitter Cards', $recordsWithTwitterTags)
                ->description('Records with Twitter tags')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('success'),
        ];
    }
}
