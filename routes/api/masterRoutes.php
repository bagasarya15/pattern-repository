<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\UserController;

Route::prefix("master")
->middleware(['auth:sanctum'])
    ->group(function () {
        Route::apiResource("users", UserController::class)->except(["show"]);
    });
