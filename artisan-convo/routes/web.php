<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConversationController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/conversations', [ConversationController::class, 'index']);
    Route::post('/conversations', [ConversationController::class, 'store']);
    Route::post('/conversations/{conversation}/messages', [ConversationController::class, 'sendMessage']);
});