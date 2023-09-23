<?php

namespace App\Providers;

use App\Events\Models\Blog\BlogDeleted;
use App\Events\Models\Comment\CommentDeleted;
use App\Listeners\DeleteBlogResources;
use App\Listeners\DeleteCommentResources;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        BlogDeleted::class => [
            DeleteBlogResources::class,
        ],
        CommentDeleted::class => [
            DeleteCommentResources::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
