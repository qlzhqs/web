<?php

use App\Http\Controllers\ActorsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\TvController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [MoviesController::class, 'index'])->name('movies.index');
Route::get('/movies/{id}', [MoviesController::class, 'show'])->name('movies.show');
Route::get('/random', [MoviesController::class, 'random'])->name('random');

Route::get('/actors', [ActorsController::class, 'index'])->name('actors.index');
Route::get('/actors/page/{page?}', [ActorsController::class, 'index']);
Route::get('/actors/{id}', [ActorsController::class, 'show'])->name('actors.show');

Route::get('/tv', [TvController::class, 'index'])->name('tv.index');
Route::get('/tv/{id}', [TvController::class, 'show'])->name('tv.show');

Route::middleware('guest')->group(function (){
    Route::get('/login',[\App\Http\Controllers\Auth\LoginController::class,'index'])->name('login');
    Route::post('/login',[\App\Http\Controllers\Auth\LoginController::class,'login'])->name('login.store');

    Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'index'])->name('register.index');
    Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    Route::post('/rating',[\App\Http\Controllers\ActionController::class,'ratingStore'])->name('rating.store');
    Route::post('/comment',[\App\Http\Controllers\ActionController::class,'comment'])->name('comment.store');
});
