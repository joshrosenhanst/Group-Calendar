<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Mdi\Mdi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
            Add support for the @materialicon() blade template directive, which outputs an SVG from the @mdi library
            $expression - The arguments for the icon:
                $name: the name of the icon (`mdi-` prefix not required). Icons listed:  https://cdn.materialdesignicons.com/3.4.93/
                $class: the class attribute of the svg output
                $size: size of the SVG, default 24
                $options: optional array of attributes that can be added to the SVG
        */
        Mdi::withIconsPath(base_path('node_modules/@mdi/svg/svg/'));
        Blade::directive('materialicon', function($expression){
            return "<?php echo(Mdi\Mdi::mdi($expression)); ?>";
        });

        /*
            @demo - check if the authenticated user is a demo account.
        */
        Blade::if('demo', function(){
            return Auth::user()->demo;
        });

        /* Set pagination custom template file */
        Paginator::defaultView('layouts.pagination');

        /*
            Collection paginate macro: Add support for a LengthAwarePaginator on a collection. This is used on the notifcations page.
        */
        if (!Collection::hasMacro('paginate')) {

            Collection::macro('paginate', function ($perPage = 15, $page = 1, $options = []) {
                return (new LengthAwarePaginator(
                    $this->forPage($page, $perPage), $this->count(), $perPage, $page, $options))
                    ->withPath('');
            });
        }
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
