<?php

namespace LaravelSeoPro\Filament\Resources\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use LaravelSeoPro\Filament\Resources\SeoMetaResource;

class ListSeoMetas extends ListRecords
{
    protected static string $resource = SeoMetaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
