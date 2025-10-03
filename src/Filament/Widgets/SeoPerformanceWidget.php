<?php

namespace LaravelSeoPro\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use LaravelSeoPro\Models\SeoMeta;
use Illuminate\Support\Facades\DB;

class SeoPerformanceWidget extends ChartWidget
{
    protected static ?string $heading = 'SEO Performance Over Time';
    
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        // Get SEO records created over the last 30 days
        $records = SeoMeta::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $data = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('M j');
            
            $record = $records->firstWhere('date', $date);
            $data[] = $record ? $record->count : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'SEO Records Created',
                    'data' => $data,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
        ];
    }
}
