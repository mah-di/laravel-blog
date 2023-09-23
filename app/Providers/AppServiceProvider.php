<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\Comment;
use App\Observers\BlogObserver;
use App\Observers\CommentObserver;
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
        Blog::observe(BlogObserver::class);
        Comment::observe(CommentObserver::class);
    }
}
