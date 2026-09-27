<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\TimelineItemController;

/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
| Authenticated area for managing Projects, Skills, Services, Timeline
| entries, Education, and inbound Contact Messages.
*/

Route::prefix('admin')->name('admin.')->group(function () {
    // Guest-only routes
    Route::middleware('admin.guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])
            ->middleware('throttle:5,1')
            ->name('login.attempt');
    });

    // Authenticated admin panel
    Route::middleware('admin.auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('projects', ProjectController::class)->except(['show']);
        Route::resource('skills', SkillController::class)->except(['show']);
        Route::resource('services', ServiceController::class)->except(['show']);
        Route::resource('timeline-items', TimelineItemController::class)
            ->except(['show'])
            ->parameters(['timeline-items' => 'timelineItem']);
        Route::resource('education', EducationController::class)->except(['show']);

        Route::get('contact-messages', [ContactMessageController::class, 'index'])
            ->name('contact-messages.index');
        Route::get('contact-messages/{contactMessage}', [ContactMessageController::class, 'show'])
            ->name('contact-messages.show');
        Route::patch('contact-messages/{contactMessage}/read', [ContactMessageController::class, 'toggleRead'])
            ->name('contact-messages.toggle-read');
        Route::post('contact-messages/read-all', [ContactMessageController::class, 'markAllRead'])
            ->name('contact-messages.read-all');
        Route::delete('contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])
            ->name('contact-messages.destroy');
    });
});
