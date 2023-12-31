<?php

namespace App\Providers\Filament;

use App\Filament\Pages\AdminUsers;
use App\Filament\Pages\Tenancy\EditEnterpriseProfile;
use App\Filament\Pages\Tenancy\RegisterEnterprise;
use App\Filament\Resources\UserResource;
use App\Models\Enterprise;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->tenant(Enterprise::class, ownershipRelationship: 'owner')
            ->tenantProfile(EditEnterpriseProfile::class)
            ->tenantMiddleware([
                
            ], isPersistent: true)
            ->brandName('Nexx Soluctions')
            ->brandLogo(asset('images/logo.png'))
            ->brandLogoHeight('2rem')
            ->navigationItems([
                NavigationItem::make('Sistema')
                    ->url('/dashboard')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->sort(-3),
            ])      
            ->tenantMenuItems([
                MenuItem::make()
                    ->url(UserResource::getSlug())
                    ->label('Usuários')
                    ->icon('heroicon-m-users'),
            ])    
            ->maxContentWidth('full')
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            // ->pages([
            //     Pages\Dashboard::class,
            // ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
