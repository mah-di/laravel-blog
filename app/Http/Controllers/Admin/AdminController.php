<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function show(Request $request): View
    {
        $admin = $request->user();
        
        $userCount = User::count();
        $newUsers = User::latest()->take(5)->get();
        $newUsers7Days = User::where('created_at', '>', now()->subDays(7)->startOfDay())->count();
        $newUsers30Days = User::where('created_at', '>', now()->subDays(30)->startOfDay())->count();
        
        $blogCount = Blog::count();
        $newBlogs = Blog::latest()->take(5)->get();
        $newBlogs7Days = Blog::where('created_at', '>', now()->subDays(7)->startOfDay())->count();
        $newBlogs30Days = Blog::where('created_at', '>', now()->subDays(30)->startOfDay())->count();

        $topBloggers = Blog::select('user_id')->groupBy('user_id')->orderByRaw('COUNT(*) DESC')->limit(3)->get();
        $topBloggers7Days = Blog::select('user_id')->groupBy('user_id')->orderByRaw('COUNT(*) DESC')->limit(3)->where('created_at', '>', now()->subDays(7)->startOfDay())->get();
        $topBloggers30Days = Blog::select('user_id')->groupBy('user_id')->orderByRaw('COUNT(*) DESC')->limit(3)->where('created_at', '>', now()->subDays(30)->startOfDay())->get();

        return view('admin.admin-dashboard', [
            'admin' => $admin,
            'userCount' => $userCount,
            'newUsers' => $newUsers,
            'newUsers7Days' => $newUsers7Days,
            'newUsers30Days' => $newUsers30Days,
            'blogCount' => $blogCount,
            'newBlogs' => $newBlogs,
            'newBlogs7Days' => $newBlogs7Days,
            'newBlogs30Days' => $newBlogs30Days,
            'topBloggers' => $topBloggers,
            'topBloggers7Days' => $topBloggers7Days,
            'topBloggers30Days' => $topBloggers30Days,
        ]);
    }

}
