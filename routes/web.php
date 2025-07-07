<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ForgotPasswordController;

// Rotas de autenticação (sem middleware auth)
Route::middleware('guest')->group(function () {
    Route::get('/login', [UserController::class, 'showLogin'])->name('login');
    Route::post('/login', [UserController::class, 'login']);
    
    Route::get('/register', [UserController::class, 'showRegister'])->name('register');
    Route::post('/register', [UserController::class, 'register']);
    
    Route::get('/2fa', [UserController::class, 'show2FA'])->name('2fa.show');
    Route::post('/2fa/verify', [UserController::class, 'verifyTwoFactor'])->name('2fa.verify');
    Route::post('/2fa/resend', [UserController::class, 'resendCode'])->name('2fa.resend');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

// Rotas protegidas (com middleware auth)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile.show');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('profile.password');
    
    // Rotas dos contatos
    Route::get('/', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::put('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

    // Rotas de notificações
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::patch('/notifications/{notification}/mark-as-unread', [NotificationController::class, 'markAsUnread'])->name('notifications.mark-as-unread');
    Route::patch('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');

    // Rota para limpar todas as notificações
    Route::delete('/clear-notifications', function () {
        $user = auth()->user();
        $user->notifications()->delete();
        
        return redirect()->route('notifications.index')
            ->with('success', 'Todas as notificações foram removidas!');
    })->name('clear.notifications');
});

// Redirecionar para login se não autenticado
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');