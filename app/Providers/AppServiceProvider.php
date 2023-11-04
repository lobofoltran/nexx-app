<?php

namespace App\Providers;

use App\Policies\CardPolicy;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('dateHour', function ($expression) {
            return "<?php echo date('d/m/Y H:i', strtotime($expression)); ?>";
        });

        Blade::directive('money', function ($amount) {
            return "<?php echo 'R$ ' . number_format($amount, 2, ',', '.'); ?>";
        });
    }
}
