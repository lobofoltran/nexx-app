<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class AdminUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;
}
