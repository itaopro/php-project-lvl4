<?php

use App\Http\Controllers\ProfileController;
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
Route::resource('task_statuses', TaskStatusController::class)->middleware('auth');
Route::middleware('auth')->group(function () {
    Route::resource('tasks', TaskController::class);
});
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');
Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
Route::get('/labels/create', [LabelController::class, 'create'])->name('labels.create');
Route::post('/labels', [LabelController::class, 'store'])->name('labels.store');
Route::get('/labels/{label}/edit', [LabelController::class, 'edit'])->name('labels.edit');
Route::put('/labels/{label}', [LabelController::class, 'update'])->name('labels.update');
Route::delete('/labels/{label}', [LabelController::class, 'destroy'])->name('labels.destroy');
Route::post('/tasks/{task}/labels', [TaskController::class, 'attachLabel'])->name('tasks.attachLabel');
Route::delete('/tasks/{task}/labels/{label}', [TaskController::class, 'detachLabel'])->name('tasks.detachLabel');
//Route::get('/', function () {
//    return view('welcome');
//});
//
//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
//
//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

//require __DIR__.'/auth.php';
