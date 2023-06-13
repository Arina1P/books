<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/book/create', [BookController::class, 'create']);
Route::patch('/book/edit/{id}', [BookController::class, 'edit']);
Route::delete('/book/remove/{id}', [BookController::class, 'remove']);

Route::post('/author/create', [AuthorController::class, 'create']);
Route::patch('/author/edit/{id}', [AuthorController::class, 'edit']);
Route::delete('/author/remove/{id}', [AuthorController::class, 'remove']);

Route::post('/genre/create', [GenreController::class, 'create']);
Route::patch('/genre/edit/{id}', [GenreController::class, 'edit']);
Route::delete('/genre/remove/{id}', [GenreController::class, 'remove']);
