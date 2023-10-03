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

Route::get('/auth', [AuthController::class, 'prepare'])->name('auth.prepare');
Route::post('/auth', [AuthController::class, 'login'])->name('auth.login');

Route::get('/tasks', function () {
    return Inertia::render('Auth/Login');
})->name('tasks.index');
