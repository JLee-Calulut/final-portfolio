<?php

use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Portfolio routes
|--------------------------------------------------------------------------
| Single primary page experience. `/home` simply redirects to `/` so both
| URLs stay consistent for navigation and CTAs.
*/

Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::get('/home', fn () => redirect()->route('home'));

// In-app calculator page (personal project), rendered through the SPA.
Route::get('/calculator', [CalculatorController::class, 'show'])->name('calculator');

// In-app todo list page (personal project), rendered through the SPA.
Route::get('/todo', [TodoController::class, 'show'])->name('todo');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store')
    ->middleware('throttle:5,1');

/*
|--------------------------------------------------------------------------
| Admin panel
|--------------------------------------------------------------------------
| Auth + dashboard + CRUD for projects, skills, services, timeline items
| and contact messages. Loaded from its own route file to keep things tidy.
*/

require __DIR__.'/admin.php';
