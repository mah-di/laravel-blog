<?php

namespace App\Http\Middleware\Custom;

use App\Models\Comment;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentAuthorCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Comment::where(['id' => $request->id, 'user_id' => $request->user()->id])->exists()) return $next($request);

        return abort(401);
    }
}
