<?php

namespace App\Providers;

use App\Models\WebSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;

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


        Paginator::useBootstrap();

        View::composer('layouts.inc.frontend.header', function ($view) {
            $web_data = WebSetting::findOrFail('d03a7f43-f1e3-47b0-8a61-21e79df08c7f');
            $view->with('web_data', $web_data);
        });

        View::composer('layouts.inc.frontend.footer', function ($view) {
            $web_data = WebSetting::findOrFail('d03a7f43-f1e3-47b0-8a61-21e79df08c7f');
            $view->with('web_data', $web_data);
        });

        Blade::directive('mongolian_currency', function ($expression) {
            return "<?php echo number_format($expression, 0, ',', \"'\"); ?>";
        });
    }
}
