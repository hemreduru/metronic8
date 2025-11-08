<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleSelectionController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::post('/lang/switch', [LanguageController::class, 'switch'])->name('lang.switch');
Route::get('/lang/available', [LanguageController::class, 'available'])->name('lang.available');
Route::get('/lang/current', [LanguageController::class, 'current'])->name('lang.current');

Route::post('/theme/switch', [ThemeController::class, 'switch'])->name('theme.switch');
Route::get('/theme/available', [ThemeController::class, 'available'])->name('theme.available');
Route::get('/theme/current', [ThemeController::class, 'current'])->name('theme.current');

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

    Route::get('/role/select', [RoleSelectionController::class, 'show'])->name('role.select');
    Route::post('/role/select', [RoleSelectionController::class, 'store'])->name('role.store');
    Route::post('/role/switch', [RoleSelectionController::class, 'switch'])->name('role.switch');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(\App\Http\Middleware\CheckPermission::class)->name('dashboard');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        Route::put('/settings', [ProfileController::class, 'updateSettings'])->name('settings.update');
        Route::post('/avatar', [ProfileController::class, 'updateAvatar'])->name('avatar.update');
        Route::delete('/avatar', [ProfileController::class, 'deleteAvatar'])->name('avatar.delete');
        Route::post('/deactivate', [ProfileController::class, 'deactivate'])->name('deactivate');
        Route::get('/export', [ProfileController::class, 'exportData'])->name('export');
    });

});
