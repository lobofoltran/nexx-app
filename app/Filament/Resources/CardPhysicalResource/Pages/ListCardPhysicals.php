<?php

namespace App\Filament\Resources\CardPhysicalResource\Pages;

use App\Filament\Resources\CardPhysicalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCardPhysicals extends ListRecords
{
    protected static string $resource = CardPhysicalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
