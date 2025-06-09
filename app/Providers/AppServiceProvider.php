<?php

namespace App\Providers;

use App\Models\Administrator;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
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
        Model::preventLazyLoading();

        Gate::define('store-comment', function (Administrator $administrator, Profile $profile) {
            return ! $profile->comments()->where('administrator_id', $administrator->id)->exists();
        });
    }
}
