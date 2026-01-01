<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasteController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [PasteController::class, 'index']);
Route::get('/pastes/create', [PasteController::class, 'create']);
Route::post('/pastes', [PasteController::class, 'store']);
Route::get('/pastes/{slug}', [PasteController::class, 'show']);
Route::delete('/pastes/{slug}', [PasteController::class, 'destroy']);

Route::get('/tos', function () {
    return Inertia::render('ToS');
});

require __DIR__.'/auth.php';
