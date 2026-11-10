<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\TicketCommentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/ping', function() {
    return response()->json([
        'message' => 'API is working'
    ]);
});

Route::get('/info', function() {
    return response()->json([
        'name' => 'Support Ticket API',
        'version' => '1.0',
        'status' => 'active'
    ]);
});

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Authentication
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Tickets CRUD
    Route::apiResource('tickets', TicketController::class);

    // Ticket comments
    Route::post('/tickets/{ticket}/comments', [TicketCommentController::class, 'store']);
});