<?php

namespace App\Filament\Resources\CardPhysicalResource\Pages;

use App\Filament\Resources\CardPhysicalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCardPhysical extends EditRecord
{
    protected static string $resource = CardPhysicalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
