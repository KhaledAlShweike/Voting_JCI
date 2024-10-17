<?php

use App\Http\Controllers\AdminsController;
use App\Http\Controllers\CandidatesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/candidates', [AdminsController::class, 'index']);

    Route::post('/candidates', [AdminsController::class, 'store']);

    Route::get('/candidates/{id}', [AdminsController::class, 'show']);

    Route::put('/candidates/{id}', [AdminsController::class, 'update']);

    Route::delete('/candidates/{id}', [AdminsController::class, 'destroy']);
});
