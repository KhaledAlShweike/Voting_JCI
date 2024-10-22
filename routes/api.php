<?php

use App\Http\Controllers\Api\CandidatesController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\VotesController;
use App\Http\Controllers\Api\AuthController;

use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Use CategoriesController for category management
Route::get('/categories', [CategoriesController::class, 'index']);
Route::post('/categories', [CategoriesController::class, 'store']);
Route::get('/categories/{id}', [CategoriesController::class, 'show']);
Route::put('/categories/{id}', [CategoriesController::class, 'update']);
Route::delete('/categories/{id}', [CategoriesController::class, 'destroy']);

// Use CandidatesController for candidate management
Route::get('/candidates', [CandidatesController::class, 'index']);
Route::post('/candidates', [CandidatesController::class, 'store']);
Route::get('/candidates/{id}', [CandidatesController::class, 'show']);
Route::put('/candidates/{id}', [CandidatesController::class, 'update']);
Route::delete('/candidates/{id}', [CandidatesController::class, 'destroy']);


//voting locking and throttling route logic
// Route::middleware('throttle:5,1')->post('/vote/{candidateId}', [VotesController::class, 'vote']);



//Auth Auth Auth Auth Auth Auth Auth Auth Auth Auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
});
