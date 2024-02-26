 <?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {

    \App\Helpers\Routes\RouteHelper::includeRouteFiles(__DIR__ . '/api/v1');

    // require __DIR__ . '/api/v1/users.php';
    // require __DIR__ . '/api/v1/clients.php';

});

Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
});
