<?php

namespace App\Http\Controllers\Like;

use App\Http\Controllers\Controller;
use App\Models\Like;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LikeController extends Controller
{
    public function Like(Request $request, int $id): RedirectResponse
    {
        if (Like::where(['user_id' => $request->user()->id, 'blog_id' => $id])->exists()) return Redirect::back()->with('error', 'Unrecognized request');

        Like::create(['user_id' => $request->user()->id, 'blog_id' => $id]);

        return Redirect::back()->with('message', 'Blog Liked!');
    }

    public function unlike(Request $request, int $id): RedirectResponse
    {
        Like::where(['user_id' => $request->user()->id, 'blog_id' => $id])->delete();

        return Redirect::back()->with('message', 'Blog Unliked!');
    }

}
