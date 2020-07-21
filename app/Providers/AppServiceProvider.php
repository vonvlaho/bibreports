<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('spaceless', function() {
            return '<?php ob_start() ?>';
        });

        Blade::directive('endspaceless', function() {
            return "<?php echo preg_replace('/\r?\n|\r/', '', ob_get_clean()); ?>";
        });
    }
}
