<?php


namespace App\Filament\Pages\Tenancy;
 
use App\Models\Enterprise;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;
use Illuminate\Database\Eloquent\Model;
 
class RegisterEnterprise extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Criar empresa';
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                // ...
            ]);
    }
    
    protected function handleRegistration(array $data): Enterprise
    {
        $enterprise = Enterprise::create($data);
        
        $enterprise->users()->attach(auth()->user());
        
        return $enterprise;
    }
}
