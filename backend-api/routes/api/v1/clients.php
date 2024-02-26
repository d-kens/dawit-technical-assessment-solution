<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
   'auth:sanctum',
])->group(function () {

    Route::get('clients', [\App\Http\Controllers\ClientController::class, 'index']);

    Route::get('clients/{client}', [\App\Http\Controllers\ClientController::class, 'show'])->whereNumber('client');

    Route::post('clients', [\App\Http\Controllers\ClientController::class, 'store']);

    Route::patch('clients/{client}', [\App\Http\Controllers\ClientController::class, 'update']);

    Route::delete('clients/{client}', [\App\Http\Controllers\ClientController::class, 'destroy']);

    Route::patch('clients/{client}/approve', [\App\Http\Controllers\ClientController::class, 'approve']);
});
