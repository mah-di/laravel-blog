<?php

use App\Http\Controllers\ContactNumberController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileImageController;
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
});

require __DIR__.'/auth.php';
