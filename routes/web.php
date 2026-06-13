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
});
