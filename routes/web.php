<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return redirect()->route('contacts.index');
});

// Rotas Contatos
Route::resource('contacts', ContactController::class)->only(['index', 'store', 'update', 'destroy']);