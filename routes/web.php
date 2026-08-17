<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramWebController;
use App\Http\Controllers\DonationWebController;
use App\Http\Controllers\NewsWebController;
use App\Http\Controllers\CategoryWebController;
use App\Http\Controllers\BankAccountWebController;
use App\Http\Controllers\WebSettingWebController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ExportController;

// Export Routes (Excel & PDF)
Route::get('/export/donations/excel', [ExportController::class, 'exportDonationsExcel'])->name('export.donations.excel');
Route::get('/export/donations/pdf', [ExportController::class, 'exportDonationsPdf'])->name('export.donations.pdf');
Route::get('/export/programs/excel', [ExportController::class, 'exportProgramsExcel'])->name('export.programs.excel');
Route::get('/export/programs/pdf', [ExportController::class, 'exportProgramsPdf'])->name('export.programs.pdf');
Route::get('/export/news/excel', [ExportController::class, 'exportNewsExcel'])->name('export.news.excel');
Route::get('/export/news/pdf', [ExportController::class, 'exportNewsPdf'])->name('export.news.pdf');
Route::get('/export/users/excel', [ExportController::class, 'exportUsersExcel'])->name('export.users.excel');
Route::get('/export/users/pdf', [ExportController::class, 'exportUsersPdf'])->name('export.users.pdf');


// ─── Root → Dashboard ────────────────────────────────────────────────────────
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// ─── Guest Auth Routes ────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ─── Protected Admin Routes ───────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/users/create', [UserController::class, 'store'])->name('user.store');
    Route::get('/users/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    // Programs
    Route::get('/programs', [ProgramWebController::class, 'index'])->name('program.index');
    Route::get('/programs/create', [ProgramWebController::class, 'create'])->name('program.create');
    Route::post('/programs', [ProgramWebController::class, 'store'])->name('program.store');
    Route::get('/programs/{program}/edit', [ProgramWebController::class, 'edit'])->name('program.edit');
    Route::patch('/programs/{program}', [ProgramWebController::class, 'update'])->name('program.update');
    Route::delete('/programs/{program}', [ProgramWebController::class, 'destroy'])->name('program.destroy');

    // Donations
    Route::get('/donations', [DonationWebController::class, 'index'])->name('donation.index');
    Route::get('/donations/{donation}', [DonationWebController::class, 'show'])->name('donation.show');
    Route::post('/donations/{donation}/confirm', [DonationWebController::class, 'confirm'])->name('donation.confirm');
    Route::post('/donations/{donation}/reject', [DonationWebController::class, 'reject'])->name('donation.reject');
    Route::delete('/donations/{donation}', [DonationWebController::class, 'destroy'])->name('donation.destroy');

    // News
    Route::get('/news-admin', [NewsWebController::class, 'index'])->name('news.index');
    Route::get('/news-admin/create', [NewsWebController::class, 'create'])->name('news.create');
    Route::post('/news-admin', [NewsWebController::class, 'store'])->name('news.store');
    Route::get('/news-admin/{news}/edit', [NewsWebController::class, 'edit'])->name('news.edit');
    Route::patch('/news-admin/{news}', [NewsWebController::class, 'update'])->name('news.update');
    Route::delete('/news-admin/{news}', [NewsWebController::class, 'destroy'])->name('news.destroy');

    // Categories
    Route::get('/categories', [CategoryWebController::class, 'index'])->name('category.index');
    Route::get('/categories/create', [CategoryWebController::class, 'create'])->name('category.create');
    Route::post('/categories', [CategoryWebController::class, 'store'])->name('category.store');
    Route::get('/categories/{category}/edit', [CategoryWebController::class, 'edit'])->name('category.edit');
    Route::patch('/categories/{category}', [CategoryWebController::class, 'update'])->name('category.update');
    Route::delete('/categories/{category}', [CategoryWebController::class, 'destroy'])->name('category.destroy');

    // Bank Accounts
    Route::get('/bank-accounts-admin', [BankAccountWebController::class, 'index'])->name('bank-account.index');
    Route::get('/bank-accounts-admin/create', [BankAccountWebController::class, 'create'])->name('bank-account.create');
    Route::post('/bank-accounts-admin', [BankAccountWebController::class, 'store'])->name('bank-account.store');
    Route::get('/bank-accounts-admin/{bankAccount}/edit', [BankAccountWebController::class, 'edit'])->name('bank-account.edit');
    Route::patch('/bank-accounts-admin/{bankAccount}', [BankAccountWebController::class, 'update'])->name('bank-account.update');
    Route::delete('/bank-accounts-admin/{bankAccount}', [BankAccountWebController::class, 'destroy'])->name('bank-account.destroy');

    // Web Settings
    Route::get('/web-settings', [WebSettingWebController::class, 'edit'])->name('web-setting.edit');
    Route::post('/web-settings', [WebSettingWebController::class, 'update'])->name('web-setting.update');

});
