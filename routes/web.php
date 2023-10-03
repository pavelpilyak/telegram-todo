<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/auth', [AuthController::class, 'prepare'])->name('login');
Route::post('/auth', [AuthController::class, 'login']);

// Available only for authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/tasks', function () {
        return Inertia::render('Auth/Login', ['userId' => auth()->user()->id]);
    })->name('tasks.index');
});
