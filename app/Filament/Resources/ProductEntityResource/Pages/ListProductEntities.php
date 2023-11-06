<?php

namespace App\Filament\Resources\ProductEntityResource\Pages;

use App\Filament\Resources\ProductEntityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductEntities extends ListRecords
{
    protected static string $resource = ProductEntityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
