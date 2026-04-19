<?php

use App\Http\Controllers\Auth\JWTAuthController;
use App\Http\Controllers\System\Coffees\CoffeeController;
use App\Http\Controllers\System\Coffees\CoffeeSettinController;
use App\Http\Controllers\System\Settings\SettinController;
use App\Http\Controllers\System\Subscriptions\SubscriptionController;
use App\Http\Controllers\System\Users\UserController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    define('PAGINATION_COUNT', 10);
    
    Route::post('register', [JWTAuthController::class, 'register']);
    Route::post('login', [JWTAuthController::class, 'login']);

    Route::middleware([JwtMiddleware::class])->group(function () {
        Route::get('user', [JWTAuthController::class, 'getUser']);
        Route::post('logout', [JWTAuthController::class, 'logout']);
        Route::post('refresh', [JWTAuthController::class, 'refresh']);

        // Users
        Route::apiResource('users', UserController::class);

        // Settings
        Route::apiResource('settings', SettinController::class);

        // Coffees
        Route::apiResource('coffees', CoffeeController::class);

        // Subscriptions
        Route::apiResource('subscriptions', SubscriptionController::class);

    });
});
