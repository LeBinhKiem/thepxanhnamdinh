<?php

namespace App\Providers;

use Dinhthang\GoogleDriveUpload\GoogleDriveUploadServiceProvider;
use Illuminate\Pagination\Paginator;
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
        $this->register(GoogleDriveUploadServiceProvider::class);
        Paginator::useBootstrap();
    }
}
