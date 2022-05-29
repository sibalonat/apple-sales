<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\VendorController;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// common attributes

function common(string $scope)
{
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
        // authenticated user
    Route::middleware(['auth:sanctum', $scope])->group(function() {
        Route::get('user', [AuthController::class, 'user']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::put('users/info', [AuthController::class, 'updateInfo']);
        Route::put('users/password', [AuthController::class, 'updatePassword']);
    });

}

//admin routes

Route::prefix('admin')->group(function() {
    common('scope.admin');

    // authenticated user
    Route::middleware(['auth:sanctum', 'scope.admin'])->group(function() {
        // all vendors
        Route::get('vendors', [VendorController::class, 'index']);
        Route::get('users/{id}/links', [LinkController::class, 'index']);

        //orders
        Route::get('orders', [OrderController::class, 'index']);

        // product resources
        Route::apiResource('products', ProductController::class);
    });

});

// vendor routes

Route::prefix('vendor')->group(function() {
    common('scope.vendor');

    Route::get('products/frontend', [ProductController::class, 'frontend']);
    Route::get('products/backend', [ProductController::class, 'backend']);

    Route::middleware(['auth:sanctum', 'scope.vendor'])->group(function() {
        Route::get('stats', [StatsController::class, 'index']);
        Route::get('rankings', [StatsController::class, 'rankings']);
        Route::post('links', [LinkController::class, 'store']);
    });
});


// checkout routes
Route::prefix('checkout')->group(function() {
    Route::get('links/{code}', [LinkController::class, 'show']);
    Route::post('orders', [OrderController::class, 'store']);
});
