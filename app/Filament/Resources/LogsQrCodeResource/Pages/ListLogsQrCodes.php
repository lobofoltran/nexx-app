<?php

namespace App\Filament\Resources\LogsQrCodeResource\Pages;

use App\Filament\Resources\LogsQrCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLogsQrCodes extends ListRecords
{
    protected static string $resource = LogsQrCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
