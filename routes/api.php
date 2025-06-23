<?php
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::prefix('tasks')->group(function () {
    Route::post('/', [TaskController::class, 'store']);
    Route::get('/', [TaskController::class, 'index']);

    Route::prefix('{id}')->group(function () {
        Route::put('/', [TaskController::class, 'update']);
        Route::patch('/status', [TaskController::class, 'changeStatus']);
        Route::delete('/', [TaskController::class, 'destroy']);
    });
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']);
