<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Users page
Route::get('/users', [UserController::class, 'index']);
// Profile page
Route::get('/users/{user_id}', [UserController::class, 'show']);
// create a new user
Route::post('/users', [UserController::class, 'store']);
// update a user
Route::put('/users/{user_id}', [UserController::class, 'update']);
// delete a user
Route::delete('/users/{user_id}', [UserController::class, 'destroy']);

// Jobs page
Route::get('/jobs', [JobController::class, 'index']);
// Job details
Route::get('/jobs/{job_id}', [JobController::class, 'show']);
// create a new job posting
Route::post('/jobs', [JobController::class, 'store']);
// update a job posting
Route::put('/jobs/{job_id}', [JobController::class, 'update']);
// delete a job posting
Route::delete('/jobs/{job_id}', [JobController::class, 'destroy']);