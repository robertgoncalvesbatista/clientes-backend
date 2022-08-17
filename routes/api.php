<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/register", [AuthController::class, "register"]);
Route::post("/authenticate", [AuthController::class, "login"]);

Route::group(["middleware" => ["auth:sanctum"]], function() {
    Route::post("/logout", [AuthController::class, "logout"]);

    // Rotas do cliente
    Route::get("/dashboard", [CustomerController::class, "index"]);
    Route::post("/customers/create", [CustomerController::class, "create"]);
    Route::get("/customers/read/{id}", [CustomerController::class, "read"]);
    Route::put("/customers/update/{id}", [CustomerController::class, "update"]);
    Route::delete("/customers/destroy/{id}", [CustomerController::class, "destroy"]);
});