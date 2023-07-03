<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResultController;
use App\Models\Game;
use App\Models\User;
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

Route::get('/', [ResultController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Start screen route
Route::get('/start', [GameController:: class, 'start'])->name('start');
Route::post('/guess', [GameController:: class, 'guess'])->name('guess');
Route::get('/gameover', [GameController:: class, 'gameOver'])->name('gameover');

