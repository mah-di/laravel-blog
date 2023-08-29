<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\BlogCreateRequest;
use App\Http\Requests\Blog\BlogUpdateRequest;
use App\Models\Blog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function show($blog_id): View
    {
        $blog = Blog::find($blog_id);

        $blogger = $blog->user;

        $relatedBlogs = Blog::fetchBlogs(5, ['user_id' => $blogger->id]);

        return view('blog.show', ['blog' => $blog, 'blogger' => $blogger, 'relatedBlogs' => $relatedBlogs]);
    }

    public function create(Request $request): View
    {
        return view('blog.create', ['user' => $request->user()]);
    }

    public function store(BlogCreateRequest $request): RedirectResponse
    {
        return Redirect::route('blog.show', [$request->blog_id]);
    }

    public function update(BlogUpdateRequest $request)
    {

    }
    public function delete(Request $request)
    {

    }
}
