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

// This group can be wrapped into `Route::middleware('guest')`,
// but if you have two or more telegram accounts in one app,
// you gonna authorize with the same account, because it's the same session.
// To prevent it, we need to authorize user every time he steps to /auth.
Route::get('auth', [AuthController::class, 'prepare'])->name('login');
Route::post('auth', [AuthController::class, 'login']);

// Available only for authenticated users
Route::middleware('auth')->group(function () {
    Route::resource('tasks', TaskController::class)->except('create', 'edit', 'show', 'update');
    Route::post('tasks/{task}/restore', [TaskController::class, 'restore'])->withTrashed();
    Route::get('tasks/archive', [TaskController::class, 'archive']);
});
