<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/tasks');
    }
    return redirect('/login');
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/api/tasks', [TaskController::class, 'index']);
Route::post('/api/tasks', [TaskController::class, 'store']);
Route::put('/api/tasks/{task}', [TaskController::class, 'update']);
Route::patch('/api/tasks/{task}', [TaskController::class, 'update']);
Route::delete('/api/tasks/{task}', [TaskController::class, 'destroy']);

Route::get('/api/categories', [CategoryController::class, 'index']);
Route::post('/api/categories', [CategoryController::class, 'store']);
Route::put('/api/categories/{category}', [CategoryController::class, 'update']);
Route::delete('/api/categories/{category}', [CategoryController::class, 'destroy']);

Route::middleware(['auth'])->get('/tasks', function () {
    return Inertia::render('Tasks/Index');
})->name('tasks');


require __DIR__.'/auth.php';
