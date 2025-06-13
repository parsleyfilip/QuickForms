<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\FormFieldController;
use App\Http\Controllers\FormResponseController;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', function () {
    return view('home');
})->name('home');

// Features page
Route::get('/features', function () {
    return view('features');
})->name('features');

// Pricing page
Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

// About page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Dashboard (Breeze default)
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

// Profile (Breeze default)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Form routes
    Route::middleware(['auth'])->group(function () {
        Route::resource('forms', FormController::class)->except(['show']);
        Route::post('forms/{form}/publish', [FormController::class, 'publish'])->name('forms.publish');
        Route::post('forms/{form}/unpublish', [FormController::class, 'unpublish'])->name('forms.unpublish');
        Route::get('forms/{form}/analytics', [FormController::class, 'analytics'])->name('forms.analytics');
        
        // Form fields
        Route::post('forms/{form}/fields', [FormFieldController::class, 'store'])->name('form-fields.store');
        Route::put('forms/{form}/fields/{field}', [FormFieldController::class, 'update'])->name('form-fields.update');
        Route::delete('forms/{form}/fields/{field}', [FormFieldController::class, 'destroy'])->name('form-fields.destroy');
        Route::post('forms/{form}/fields/reorder', [FormFieldController::class, 'reorder'])->name('form-fields.reorder');
        
        // Form responses
        Route::get('forms/{form}/responses', [FormResponseController::class, 'index'])->name('form-responses.index');
        Route::get('forms/{form}/responses/{response}', [FormResponseController::class, 'show'])->name('form-responses.show');
        Route::delete('forms/{form}/responses/{response}', [FormResponseController::class, 'destroy'])->name('form-responses.destroy');
        Route::get('forms/{form}/responses/export', [FormResponseController::class, 'export'])->name('form-responses.export');
    });
});

// Public form routes
Route::get('forms/{form}', [FormController::class, 'show'])->name('forms.show');
Route::post('forms/{form}/submit', [FormController::class, 'submit'])->name('forms.submit');

require __DIR__.'/auth.php';
