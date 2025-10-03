<?php

namespace LaravelSeoPro\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use LaravelSeoPro\Models\SeoMeta;
use Illuminate\Support\Facades\DB;

class SeoAuditDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    
    protected static ?string $navigationGroup = 'SEO';
    
    protected static ?int $navigationSort = 4;
    
    protected static string $view = 'seo::filament.pages.seo-audit-dashboard';
    
    protected static ?string $title = 'SEO Audit Dashboard';
    
    protected static ?string $slug = 'seo-audit-dashboard';

    public $auditResults = [];
    public $totalRecords = 0;
    public $issuesFound = 0;

    public function mount()
    {
        $this->runAudit();
    }

    public function runAudit()
    {
        $this->totalRecords = SeoMeta::count();
        
        $this->auditResults = [
            'missing_titles' => SeoMeta::whereNull('title')->count(),
            'missing_descriptions' => SeoMeta::whereNull('description')->count(),
            'missing_keywords' => SeoMeta::whereNull('keywords')->count(),
            'missing_og_tags' => SeoMeta::whereNull('og_title')->count(),
            'missing_twitter_tags' => SeoMeta::whereNull('twitter_title')->count(),
            'missing_canonical_urls' => SeoMeta::whereNull('canonical_url')->count(),
            'short_titles' => SeoMeta::whereRaw('CHAR_LENGTH(title) < 30')->whereNotNull('title')->count(),
            'long_titles' => SeoMeta::whereRaw('CHAR_LENGTH(title) > 60')->whereNotNull('title')->count(),
            'short_descriptions' => SeoMeta::whereRaw('CHAR_LENGTH(description) < 120')->whereNotNull('description')->count(),
            'long_descriptions' => SeoMeta::whereRaw('CHAR_LENGTH(description) > 160')->whereNotNull('description')->count(),
        ];

        $this->issuesFound = array_sum($this->auditResults);

        Notification::make()
            ->title('SEO Audit Complete')
            ->body("Found {$this->issuesFound} issues across {$this->totalRecords} records")
            ->success()
            ->send();
    }

    public function exportAuditResults()
    {
        // This would export audit results to CSV or PDF
        Notification::make()
            ->title('Export Started')
            ->body('Audit results are being exported...')
            ->info()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('refresh')
                ->label('Refresh Audit')
                ->icon('heroicon-o-arrow-path')
                ->action('runAudit')
                ->color('primary'),
            
            Action::make('export')
                ->label('Export Results')
                ->icon('heroicon-o-arrow-down-tray')
                ->action('exportAuditResults')
                ->color('gray'),
        ];
    }
}
