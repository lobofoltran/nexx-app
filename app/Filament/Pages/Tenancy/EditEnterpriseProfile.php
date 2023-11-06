<?php

namespace App\Filament\Pages\Tenancy;
 
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile;
use Illuminate\Database\Eloquent\Model;
 
class EditEnterpriseProfile extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Configurações';
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Configurações da Empresa')
                ->schema([
                    TextInput::make('name')
                        ->label('Nome')
                        ->maxLength(30),
                    Toggle::make('teste')
                        ->label('Permite apagar comandas')
                ])
        ]);
    }
}
