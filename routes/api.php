<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovieListController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login',[UserController::class,'login'])->name('user-login');
Route::post('/register',[UserController::class,'register'])->name('user-register');

Route::get('/movieList',[MovieListController::class,'index'])->name('movie-list')->middleware(['auth:sanctum','userAccess']);
Route::get('/movieDetails',[MovieListController::class,'movieDetails'])->name('movie-details')->middleware(['auth:sanctum','userAccess']);
Route::post('/movieUpdate',[MovieListController::class,'movieUpdate'])->name('movie-update')->middleware(['auth:sanctum','userAccess']);
Route::delete('/movieDelete',[MovieListController::class,'movieDelete'])->name('movie-delete')->middleware(['auth:sanctum','userAccess']);

//Using 2nd API
Route::get('/starwarFilms',[MovieListController::class,'starwarFilms'])->name('starwarFilms-list')->middleware(['auth:sanctum','userAccess']);
Route::get('/starwarFilmDetails',[MovieListController::class,'starwarFilmDetails'])->name('starwarFilm-detail')->middleware(['auth:sanctum','userAccess']);
Route::post('/starwarFilmUpdate',[MovieListController::class,'starwarFilmUpdate'])->name('starwarFilm-detail')->middleware(['auth:sanctum','userAccess']);
Route::delete('/starwarFilmDelete',[MovieListController::class,'starwarFilmDelete'])->name('starwarFilm-detail')->middleware(['auth:sanctum','userAccess']);
