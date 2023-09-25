<?php

namespace App\Listeners;

use App\Models\Comment;
use App\Models\Like;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteCommentResources
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
        Like::where(['likable_type' => Comment::class, 'likable_id' => $event->comment->id])->delete();

        $comments = Comment::where(['parent_id' => $event->comment->id])->get();

        foreach ($comments as $comment)
        {

            $comment->delete();

        }
    }
}
