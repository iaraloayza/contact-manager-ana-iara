<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreateContactController;

Route::get('/', function () {
    return redirect()->route('contacts.index');
});

// Rotas Contatos
Route::resource('contacts', CreateContactController::class)->only(['index', 'store', 'update', 'destroy']);