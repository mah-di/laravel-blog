<?php

namespace App\Listeners;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteBlogResources
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        Like::where(['likable_type' => Blog::class, 'likable_id' => $event->blog->id])->delete();

        foreach (Comment::where(['blog_id' => $event->blog->id, 'parent_id' => null])->get() as $comment)
        {

            $comment->delete();

        }
    }
}
