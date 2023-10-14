<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/blogs/{user_id}', [ProfileController::class, "getBlogs"])->name('profile.blogs');
Route::get('/category/blogs/{id}', [CategoryController::class, "fetchBlogs"])->name('category.blogs');
Route::get('/sub_category/blogs/{id}', [SubCategoryController::class, "fetchBlogs"])->name('subCategory.blogs');
Route::get('/user/{id}/liked-blogs', [ProfileController::class, "getLikedBlogs"])->name('user.likedBlogs');
Route::get('/user/{id}/liked-comments', [ProfileController::class, "getLikedComments"])->name('user.likedComments');
