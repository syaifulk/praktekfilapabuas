<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Policies\postPolicy;
use Illuminate\Support\Facades\URL;

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
        //
        Gate::policy(Post::class, PostPolicy::class);
        if ($this->app->environment('production')) {
            $this->app['request']->server->set('HTTPS', 'on');
            URL::forceScheme('https');
        }
    }
}