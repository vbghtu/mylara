<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/', [MainController::class, 'index'])->name('admin.index');
});

Route::get('/', [MainController::class, 'index'])->name('index');
