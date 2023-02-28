<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Guest\ProjectController as GuestProjectController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [GuestProjectController::class, 'index'])->name('guest.index');

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::name('projects.')->prefix('projects')->group(function () {
    Route::get('/trash', [AdminProjectController::class, 'trashed'])->name('trash');
    Route::post('/{project}/restore', [AdminProjectController::class, 'restore'])->name('restore');
    Route::delete('/{project}/force-delete', [AdminProjectController::class, 'forceDelete'])->name('force-delete');
});

Route::middleware(['auth', 'verified'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function() {
        Route::get('/', [AdminDashboardController::class, 'index'])
        ->name('dashboard');
        Route::resource('projects', AdminProjectController::class);
    });



require __DIR__.'/auth.php';
