<?php

namespace LaravelSeoPro\Filament\Resources\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use LaravelSeoPro\Filament\Resources\SeoMetaResource;

class EditSeoMeta extends EditRecord
{
    protected static string $resource = SeoMetaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
