<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
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

Route::middleware('guest')->group(function () {
    Route::get('auth', [AuthController::class, 'prepare'])->name('login');
    Route::post('auth', [AuthController::class, 'login']);
});

// Available only for authenticated users
Route::middleware('auth')->group(function () {
    Route::resource('tasks', TaskController::class)->except('create', 'edit', 'show', 'update');
    Route::post('tasks/{task}/restore', [TaskController::class, 'restore'])->withTrashed();
    Route::get('tasks/archive', [TaskController::class, 'archive']);
});
