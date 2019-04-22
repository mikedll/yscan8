<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Youtube;

/*
  Wraps vendor youtube to allow testing with non-static methods.
 */
class YoutubeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {        
        $this->app->singleton(Youtube::class, function() {
            $vendorYoutube = $this->app->make('Youtube');
            return new Youtube($vendorYoutube);
        });
    }
}
