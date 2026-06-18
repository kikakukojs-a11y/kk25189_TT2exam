<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\CharacteristicController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\TrashController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\FavoriteController;

Route::get('/', function () {
    return redirect()->route('animals.index');
});

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'lv', 'es', 'de'])) { 
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/animals', [AnimalController::class, 'index'])->name('animals.index');

// Guest
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']); 

    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/animals/{animal}/favorite', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/animals/{animal}', [AnimalController::class, 'show'])->name('animals.show');

    // Registered User
    Route::middleware(['role:Registered User'])->group(function () {
        Route::get('/my-applications', [ApplicationController::class, 'index'])->name('applications.index');
        Route::get('/animals/{animal}/apply', [ApplicationController::class, 'create'])->name('applications.create');
        Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');
        Route::get('/my-favorites', [AnimalController::class, 'showFavorites'])->name('favorites.index');
    });

    // Admin
    Route::middleware([\App\Http\Middleware\AdminMiddleware::class])
        ->prefix('admin')
        ->name('admin.') 
        ->group(function () {
            Route::get('/applications', [AdminApplicationController::class, 'index'])->name('applications.index');
            Route::patch('/applications/{id}', [AdminApplicationController::class, 'update'])->name('applications.update');

            // Characteristics
            Route::get('/characteristics', [CharacteristicController::class, 'index'])->name('characteristics.index');
            Route::post('/characteristics', [CharacteristicController::class, 'store'])->name('characteristics.store');
            Route::delete('/characteristics/{characteristic}', [CharacteristicController::class, 'destroy'])->name('characteristics.destroy');

            // Categories
            Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
            Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
            Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

            // Animals Management
            Route::get('/animals/create', [AnimalController::class, 'create'])->name('animals.create');
            Route::post('/animals', [AnimalController::class, 'store'])->name('animals.store');
            Route::get('/animals/{animal}/edit', [AnimalController::class, 'edit'])->name('animals.edit');
            Route::put('/animals/{animal}', [AnimalController::class, 'update'])->name('animals.update');
            Route::delete('/animals/{animal}', [AnimalController::class, 'destroy'])->name('animals.destroy');

            // Trash Controls
            Route::get('/trash', [TrashController::class, 'index'])->name('trash.index');
            Route::post('/trash/animals/{id}/restore', [TrashController::class, 'restoreAnimal'])->name('trash.animals.restore');
            Route::delete('/trash/animals/{id}/force-delete', [TrashController::class, 'forceDeleteAnimal'])->name('trash.animals.force-delete');
            
            Route::post('/trash/categories/{id}/restore', [TrashController::class, 'restoreCategory'])->name('trash.categories.restore');
            Route::delete('/trash/categories/{id}/force-delete', [TrashController::class, 'forceDeleteCategory'])->name('trash.categories.force-delete');
        });
});

if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}
Route::get('/test-disk', function () {
    return response()->json([
        'current_default_disk' => config('filesystems.default'),
        'env_filesystem_disk'  => env('FILESYSTEM_DISK'),
        'aws_url_value'        => config('filesystems.disks.s3.url'),
    ]);
});