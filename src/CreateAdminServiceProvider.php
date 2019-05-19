<?php
namespace Wirelab\CreateAdmin;

    use Illuminate\Support\ServiceProvider;
    class CreateAdminServiceProvider extends ServiceProvider {
        public function boot()
        {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateAdmin::class
            ]);
        }
        }
        public function register()
        {
        }
    }
    ?>