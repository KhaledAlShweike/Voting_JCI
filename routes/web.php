<?php

use App\Http\Controllers\AdminsController;
use App\Http\Controllers\CandidatesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VotesController;
use Illuminate\Http\Request;



Route::get('/', function () {
    return view('welcome');
});



// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// Route::middleware('auth:sanctum')->group(function ()
// {
//     Route::post('/vote/{candidateId}',[VotesController::class, 'vote']);
// });


