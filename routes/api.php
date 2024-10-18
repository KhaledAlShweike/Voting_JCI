<?php

use App\Http\Controllers\CandidatesController;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Use CandidatesController for candidate management
Route::get('/candidates', [CandidatesController::class, 'index']);
Route::post('/candidates', [CandidatesController::class, 'store']);
Route::get('/candidates/{id}', [CandidatesController::class, 'show']);
Route::put('/candidates/{id}', [CandidatesController::class, 'update']);
Route::delete('/candidates/{id}', [CandidatesController::class, 'destroy']);

Route::middleware('auth:sanctum')->group(function () {
});
