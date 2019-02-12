<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Mdi\Mdi;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Mdi::withIconsPath(base_path('node_modules/@mdi/svg/svg/'));
        Blade::directive('materialicon', function($expression){
            return "<?php echo(Mdi\Mdi::mdi($expression)); ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
