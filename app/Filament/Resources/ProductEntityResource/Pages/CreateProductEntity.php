<?php

namespace App\Filament\Resources\ProductEntityResource\Pages;

use App\Filament\Resources\ProductEntityResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProductEntity extends CreateRecord
{
    protected static string $resource = ProductEntityResource::class;
}
