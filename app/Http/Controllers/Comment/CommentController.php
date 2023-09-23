<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentCreateRequest;
use App\Http\Requests\Comment\CommentUpdateRequest;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{
    public function postComment(CommentCreateRequest $request): RedirectResponse
    {
        return Redirect::back()->with('message', 'Comment posted');
    }

    public function deleteComment(Request $request): RedirectResponse
    {
        Comment::find($request->id)->delete();

        return Redirect::back()->with('message', 'Comment deleted');
    }

    public function updateComment(CommentUpdateRequest $request): RedirectResponse
    {
        return Redirect::back()->with('message', 'Comment updated');
    }

}
