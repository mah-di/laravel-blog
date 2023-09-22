<?php

namespace App\Http\Controllers\Like;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LikeController extends Controller
{
    public function likeBlog(Request $request, int $id): RedirectResponse
    {
        if (Like::where(['user_id' => $request->user()->id, 'likable_id' => $id, 'likable_type' => Blog::class])->exists()) return Redirect::back()->with('error', 'Unrecognized request');

        Like::create(['user_id' => $request->user()->id, 'likable_id' => $id, 'likable_type' => Blog::class]);

        return Redirect::back()->with('message', 'Blog Liked!');
    }

    public function unlikeBlog(Request $request, int $id): RedirectResponse
    {
        Like::where(['user_id' => $request->user()->id, 'likable_id' => $id, 'likable_type' => Blog::class])->delete();

        return Redirect::back()->with('message', 'Blog Unliked!');
    }

    public function likeComment(Request $request, int $id): RedirectResponse
    {
        if (Like::where(['user_id' => $request->user()->id, 'likable_id' => $id, 'likable_type' => Comment::class])->exists()) return Redirect::back()->with('error', 'Unrecognized request');

        Like::create(['user_id' => $request->user()->id, 'likable_id' => $id, 'likable_type' => Comment::class]);

        return Redirect::back()->with('message', 'Comment Liked!');
    }

    public function unlikeComment(Request $request, int $id): RedirectResponse
    {
        Like::where(['user_id' => $request->user()->id, 'likable_id' => $id, 'likable_type' => Comment::class])->delete();

        return Redirect::back()->with('message', 'Comment Unliked!');
    }

}
