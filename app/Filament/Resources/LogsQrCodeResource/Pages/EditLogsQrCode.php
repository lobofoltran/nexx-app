<?php

namespace App\Filament\Resources\LogsQrCodeResource\Pages;

use App\Filament\Resources\LogsQrCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLogsQrCode extends EditRecord
{
    protected static string $resource = LogsQrCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
