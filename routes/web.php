<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\ContactNumberController;
use App\Http\Controllers\Like\LikeController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileImageController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'admin.check'])->group(function () {
    Route::get('/admin', [AdminController::class, 'show'])->name('admin.dashboard');

    Route::get('/admin/categories', [CategoryController::class, 'show'])->name('category.show');
    Route::get('/admin/create/category', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/admin/create/category', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/admin/edit/category/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::patch('/admin/edit/category/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/admin/category/{id}', [CategoryController::class, 'delete'])->name('category.delete');

    Route::post('/admin/sub-category', [SubCategoryController::class, 'create'])->name('subCategory.create');
    Route::delete('/admin/sub-category/{id}', [SubCategoryController::class, 'delete'])->name('subCategory.delete');
});

Route::get('/auth/github/redirect', [OAuthController::class, 'githubRedirect'])->name('login.github');
Route::get('/auth/github/callback', [OAuthController::class, 'githubCallback'])->name('callback.github');

Route::get('/auth/google/redirect', [OAuthController::class, 'googleRedirect'])->name('login.google');
Route::get('/auth/google/callback', [OAuthController::class, 'googleCallback'])->name('callback.google');

Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'showDashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/contact', [ContactNumberController::class, 'update'])->name('contact.update');
    Route::delete('/profile/contact', [ContactNumberController::class, 'delete'])->name('contact.delete');
    Route::patch('/profile/image', [ProfileImageController::class, 'update'])->name('profile.image.update');
    Route::delete('/profile/image', [ProfileImageController::class, 'delete'])->name('profile.image.delete');
    
    Route::get('/blog/create/step/1', [BlogController::class, 'showStep1'])->name('blog.show.step1');
    Route::post('/blog/create/step/1', [BlogController::class, 'storeStep1'])->name('blog.store.step1');
    Route::get('/blog/create/step/2', [BlogController::class, 'showStep2'])->name('blog.show.step2');
    Route::post('/blog/create/step/2', [BlogController::class, 'storeStep2'])->name('blog.store.step2');
    Route::get('/blog/create/step/3', [BlogController::class, 'showStep3'])->name('blog.show.step3');
    Route::post('/blog/create', [BlogController::class, 'storeStep3'])->name('blog.store.step3');

    Route::middleware('blog.author.check')->group(function () {
        Route::get('/blog/update/{id}', [BlogController::class, 'edit'])->name('blog.edit');
        Route::patch('/blog/update/{id}', [BlogController::class, 'update'])->name('blog.update');
        Route::get('/blog/category/update/{id}', [BlogController::class, 'editCategory'])->name('blog.category.edit');
        Route::patch('/blog/category/update/{id}', [BlogController::class, 'updateCategory'])->name('blog.category.update');
        Route::get('/blog/sub-category/update/{id}', [BlogController::class, 'editSubCategory'])->name('blog.subCategory.edit');
        Route::patch('/blog/sub-category/update/{id}', [BlogController::class, 'updateSubCategory'])->name('blog.subCategory.update');
        Route::delete('/blog/cover-image/delete/{id}', [BlogController::class, 'deleteCoverImage'])->name('cover.image.delete');
        Route::delete('/blog/delete/{id}', [BlogController::class, 'delete'])->name('blog.delete');
    });

    Route::post('/blog/like/{id}', [LikeController::class, 'likeBlog'])->name('blog.like');
    Route::delete('/blog/like/{id}', [LikeController::class, 'unlikeBlog'])->name('blog.unlike');
    
    Route::middleware('comment.author.check')->group(function () {
        Route::delete('/comment/delete', [CommentController::class, 'deleteComment'])->name('comment.delete');
        Route::patch('/comment/update', [CommentController::class, 'updateComment'])->name('comment.update');
    });
    
    Route::post('/comment/post', [CommentController::class, 'postComment'])->name('blog.comment');
    Route::post('/comment/like/{id}', [LikeController::class, 'likeComment'])->name('comment.like');
    Route::delete('/comment/like/{id}', [LikeController::class, 'unlikeComment'])->name('comment.unlike');

});


Route::get('/blog/{id}', [BlogController::class, 'show'])->middleware('blog.exists')->name('blog.show');

Route::get('/category/{id}', [CategoryController::class, 'showBlogs'])->name('category.blogs.show');
Route::get('/sub_category/{id}', [SubCategoryController::class, 'showBlogs'])->name('subCategory.blogs.show');

require __DIR__.'/auth.php';
