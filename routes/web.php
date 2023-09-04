<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactNumberController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/auth/github/redirect', [OAuthController::class, 'githubRedirect'])->name('login.github');
Route::get('/auth/github/callback', [OAuthController::class, 'githubCallback'])->name('callback.github');

Route::get('/auth/google/redirect', [OAuthController::class, 'googleRedirect'])->name('login.google');
Route::get('/auth/google/callback', [OAuthController::class, 'googleCallback'])->name('callback.google');

Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');

Route::middleware('auth')->group(function () {
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
    Route::patch('/blog/update', [BlogController::class, 'update'])->name('blog.update');
    Route::delete('/blog/delete', [BlogController::class, 'delete'])->name('blog.delete');
});

Route::get('/blog/{blog_id}', [BlogController::class, 'show'])->name('blog.show');

require __DIR__.'/auth.php';
