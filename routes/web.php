<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDetailsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Routes for User CRUD operations
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/create', [UserController::class, 'create']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::get('/users/{user}/edit', [UserController::class, 'edit']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);

// Routes for UserDetails CRUD operations
Route::get('/user-details', [UserDetailsController::class, 'index']);
Route::get('/user-details/create', [UserDetailsController::class, 'create']);
Route::post('/user-details', [UserDetailsController::class, 'store']);
Route::get('/user-details/{user_details}', [UserDetailsController::class, 'show']);
Route::get('/user-details/{user_details}/edit', [UserDetailsController::class, 'edit']);
Route::put('/user-details/{user_details}', [UserDetailsController::class, 'update']);
Route::delete('/user-details/{user_details}', [UserDetailsController::class, 'destroy']);