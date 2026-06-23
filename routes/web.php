<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PublicQuoteController;
use App\Http\Controllers\Auth\ClientAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Inspira\CinetPayController;
use App\Http\Controllers\Inspira\InspiraController;
use App\Http\Controllers\Inspira\InspiraDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public pages
Route::get('/', [PageController::class, 'index'])->name('public.index');
Route::get('/portfolio', [PageController::class, 'portfolio'])->name('public.portfolio');
Route::get('/services', [PageController::class, 'services'])->name('public.services');
Route::get('/about', [PageController::class, 'about'])->name('public.about');
Route::get('/contact', [PageController::class, 'contact'])->name('public.contact');

// Devis Submission
Route::post('/devis/envoyer', [PublicQuoteController::class, 'store'])->name('public.devis.store');

// Client Auth Routes
Route::get('/login', [ClientAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [ClientAuthController::class, 'login']);
Route::get('/register', [ClientAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [ClientAuthController::class, 'register']);
Route::post('/logout', [ClientAuthController::class, 'logout'])->name('logout');

// Google OAuth
Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Admin Auth Routes
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Panel Routes (Protected by auth and custom IsAdmin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Devis
    Route::get('/devis', [QuoteController::class, 'index'])->name('devis.index');
    Route::patch('/devis/{quote}/status', [QuoteController::class, 'updateStatus'])->name('devis.update-status');

    // Projets / Kanban
    Route::get('/projets', [ProjectController::class, 'index'])->name('projects.index');
    Route::post('/projets', [ProjectController::class, 'store'])->name('projects.store');
    Route::patch('/projets/{project}/step', [ProjectController::class, 'updateStep'])->name('projects.update-step');
    Route::patch('/projets/{project}/progress', [ProjectController::class, 'updateProgress'])->name('projects.update-progress');
    Route::delete('/projets/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    // Clients
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/{client}', [ClientController::class, 'show'])->name('clients.show');
    Route::patch('/clients/{client}/toggle-status', [ClientController::class, 'toggleStatus'])->name('clients.toggle-status');

    // Témoignages CRUD
    Route::resource('testimonials', TestimonialController::class)->except(['show']);

    // Vidéos Portfolio CRUD
    Route::resource('videos', VideoController::class)->except(['show']);

    // Inspira — Admin management
    Route::prefix('inspira')->name('inspira.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\Inspira\DashboardController::class, 'index'])->name('dashboard');

        Route::get('/plans', [\App\Http\Controllers\Admin\Inspira\PlanController::class, 'index'])->name('plans.index');
        Route::get('/plans/create', [\App\Http\Controllers\Admin\Inspira\PlanController::class, 'create'])->name('plans.create');
        Route::post('/plans', [\App\Http\Controllers\Admin\Inspira\PlanController::class, 'store'])->name('plans.store');
        Route::get('/plans/{plan}/edit', [\App\Http\Controllers\Admin\Inspira\PlanController::class, 'edit'])->name('plans.edit');
        Route::put('/plans/{plan}', [\App\Http\Controllers\Admin\Inspira\PlanController::class, 'update'])->name('plans.update');
        Route::post('/plans/{plan}/toggle-status', [\App\Http\Controllers\Admin\Inspira\PlanController::class, 'toggleStatus'])->name('plans.toggle-status');

        Route::get('/subscribers', [\App\Http\Controllers\Admin\Inspira\SubscriberController::class, 'index'])->name('subscribers.index');
        Route::get('/subscribers/{subscription}', [\App\Http\Controllers\Admin\Inspira\SubscriberController::class, 'show'])->name('subscribers.show');
        Route::post('/subscribers/{subscription}/status', [\App\Http\Controllers\Admin\Inspira\SubscriberController::class, 'updateStatus'])->name('subscribers.update-status');

        Route::get('/payments', [\App\Http\Controllers\Admin\Inspira\PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{payment}', [\App\Http\Controllers\Admin\Inspira\PaymentController::class, 'show'])->name('payments.show');

        Route::get('/ideas', [\App\Http\Controllers\Admin\Inspira\IdeaController::class, 'index'])->name('ideas.index');

        Route::get('/config', [\App\Http\Controllers\Admin\Inspira\ConfigController::class, 'index'])->name('config');
        Route::post('/config', [\App\Http\Controllers\Admin\Inspira\ConfigController::class, 'update'])->name('config.update');
    });
});

// CinetPay webhook (CSRF exempt, public)
Route::post('/cinetpay/notify', [CinetPayController::class, 'notify'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
Route::get('/cinetpay/return', [CinetPayController::class, 'return'])->name('cinetpay.return');

// Inspira — Public pages
Route::prefix('inspira')->name('inspira.')->group(function () {
    Route::get('/', [InspiraController::class, 'index'])->name('index');
    Route::get('/tarifs', [InspiraController::class, 'tarifs'])->name('tarifs');
    Route::post('/subscribe/{subscription_plan}', [InspiraController::class, 'subscribe'])->name('subscribe');

    // Inspira — Authenticated pages
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [InspiraDashboardController::class, 'index'])->name('dashboard')
            ->middleware('subscription');
        Route::get('/dashboard/profil', [InspiraDashboardController::class, 'editProfil'])->name('profile')
            ->middleware('subscription');
        Route::put('/dashboard/profil', [InspiraDashboardController::class, 'updateProfil'])->name('profile.update')
            ->middleware('subscription');
    });
});
