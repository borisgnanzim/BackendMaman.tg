<?php

namespace App\Providers;

use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\EloquentArticleRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(ArticleRepositoryInterface::class, EloquentArticleRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
