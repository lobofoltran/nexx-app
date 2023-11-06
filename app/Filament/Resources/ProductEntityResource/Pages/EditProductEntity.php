<?php

namespace App\Filament\Resources\ProductEntityResource\Pages;

use App\Filament\Resources\ProductEntityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductEntity extends EditRecord
{
    protected static string $resource = ProductEntityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
