<?php

use App\Enums\UserRole;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShowcaseController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::middleware([UserRole::ADMIN->value, UserRole::MODERATOR->value])->group(function () {
    Route::get('/adminarea/', [AdminController::class, 'index'])->name('admin.index');
});

// только авторизированным не зависимо от роли
Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('profile', [ProfileController::class, 'store'])->name('profile.store');
});


Route::middleware(['auth', 'role:admin,moderator,seller'])->group(function () {
    Route::get('/products/page/{page}', [ProductController::class, 'index'])
        ->where('page', '[1-9][0-9]*')
        ->name('products.index.page');

    Route::resource('products', ProductController::class);
});

Route::middleware(['auth', 'role:admin,moderator'])->group(function () {
    Route::get('/categories/page/{page}', [CategoryController::class, 'index'])
        ->where('page', '[1-9][0-9]*')
        ->name('categories.index.page');

    Route::resource('categories', CategoryController::class);
});


// Всем посетителям
Route::middleware(['web'])->group(function () {
// Форма входа
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
// Форма регистрации
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

    /* магазины*/
    Route::get('/{showcase}', [ShowcaseController::class, 'index'])
        ->name('showcase');

    Route::get('/{showcase}/page/{page}', [ShowcaseController::class, 'index'])
        ->where('page', '[1-9][0-9]*')
        ->name('showcase.page');


    Route::get('/page/{page}', [MainController::class, 'index'])
        ->where('page', '[1-9][0-9]*')
        ->name('home.index.page');
    Route::get('/', [MainController::class, 'index'])->name('home');
    Route::get('/{categorySlug}', [SiteController::class, 'categories'])->name('category');
    Route::get('/{categorySlug}/page/{page}', [SiteController::class, 'categories'])
        ->where('page', '[1-9][0-9]*')
        ->name('category.page');
    Route::get('product/{productSlug}', [SiteController::class, 'product'])->name('product');


});
