<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function show(Request $request)
    {
        $userCount = User::count();
        $newUsers = User::latest()->take(5);
        $blogCount = Blog::count();
        $newBlogs = Blog::latest()->take(5);
        dd($request->user());
    }
}
