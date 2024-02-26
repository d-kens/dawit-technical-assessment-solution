<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
//    'auth:api',
])
    ->name('clients.')
    ->namespace("\App\Http\Controllers")
    ->group(function () {
        Route::get('clients', [\App\Http\Controllers\ClientController::class, 'index'])->name('index');

        Route::get('clients/{client}', [\App\Http\Controllers\ClientController::class, 'show'])->name('show')->whereNumber('client');

        Route::post('clients', [\App\Http\Controllers\ClientController::class, 'store'])->name('store');

        Route::patch('clients/{client}', [\App\Http\Controllers\ClientController::class, 'update'])->name('update');

        Route::delete('clients/{client}', [\App\Http\Controllers\ClientController::class, 'destroy'])->name('destroy');

        Route::patch('clients/{client}/approve', [\App\Http\Controllers\ClientController::class, 'approve'])->name('approve');

    });
