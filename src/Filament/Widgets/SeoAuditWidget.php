<?php

namespace LaravelSeoPro\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use LaravelSeoPro\Models\SeoMeta;
use Illuminate\Support\Facades\DB;

class SeoAuditWidget extends ChartWidget
{
    protected static ?string $heading = 'SEO Audit Results';
    
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $auditData = [
            'Missing Titles' => SeoMeta::whereNull('title')->count(),
            'Missing Descriptions' => SeoMeta::whereNull('description')->count(),
            'Missing Keywords' => SeoMeta::whereNull('keywords')->count(),
            'Missing OG Tags' => SeoMeta::whereNull('og_title')->count(),
            'Missing Twitter Tags' => SeoMeta::whereNull('twitter_title')->count(),
            'Missing Canonical URLs' => SeoMeta::whereNull('canonical_url')->count(),
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Missing SEO Elements',
                    'data' => array_values($auditData),
                    'backgroundColor' => [
                        '#ef4444', // red
                        '#f97316', // orange
                        '#eab308', // yellow
                        '#22c55e', // green
                        '#3b82f6', // blue
                        '#8b5cf6', // purple
                    ],
                    'borderColor' => '#ffffff',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => array_keys($auditData),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
