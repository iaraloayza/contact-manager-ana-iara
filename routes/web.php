<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;

// Rotas de autenticação (sem middleware auth)
Route::middleware('guest')->group(function () {
    Route::get('/login', [UserController::class, 'showLogin'])->name('login');
    Route::post('/login', [UserController::class, 'login']);
    
    Route::get('/register', [UserController::class, 'showRegister'])->name('register');
    Route::post('/register', [UserController::class, 'register']);
    
    Route::get('/2fa', [UserController::class, 'show2FA'])->name('2fa.show');
    Route::post('/2fa/verify', [UserController::class, 'verifyTwoFactor'])->name('2fa.verify');
    Route::post('/2fa/resend', [UserController::class, 'resendCode'])->name('2fa.resend');
});

// Rotas protegidas (com middleware auth)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    
    // Rotas dos contatos
    Route::get('/', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::put('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
});

// Redirecionar para login se não autenticado
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');