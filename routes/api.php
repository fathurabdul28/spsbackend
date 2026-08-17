<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DonationController;
use App\Http\Controllers\API\ProgramController;
use App\Http\Controllers\API\NewsController;

// API News
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{slug}', [NewsController::class, 'show']);

use App\Http\Controllers\API\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/google-login', [AuthController::class, 'googleLogin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/my-donations', [DonationController::class, 'myDonations']);
});

// API Programs
Route::get('/programs', [ProgramController::class, 'index']);
Route::get('/programs/{slug}', [ProgramController::class, 'show']);

// API Donasi
Route::post('/donations', [DonationController::class, 'store']);
Route::post('/midtrans/webhook', [DonationController::class, 'webhook']);
Route::post('/donations/{id}/upload-receipt', [DonationController::class, 'uploadReceipt']);
Route::get('/bank-accounts', function () { return \App\Models\BankAccount::where('is_active', true)->get(); });
