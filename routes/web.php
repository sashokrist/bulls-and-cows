<?php

use App\Http\Controllers\GameController;
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

Route::get('/', function () {
    $results = Game::orderBy('time')->take(10)->with('user')->get(['user_id', 'time']);
    $users = User::whereIn('id', $results->pluck('user_id'))->get(['id', 'name']);

    $formattedResults = $results->map(function ($result) use ($users) {
        $user = $users->where('id', $result->user_id)->first();
        return [
            'user_id' => $result->user_id,
            'username' => $user->name,
            'time' => $result->time,
        ];
    });

    return view('main', compact('formattedResults'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Start screen route
Route::get('/start', [GameController:: class, 'start'])->name('start');
Route::post('/guess', [GameController:: class, 'guess'])->name('guess');
Route::get('/result', [GameController:: class, 'result'])->name('result');
Route::get('/gameover', [GameController:: class, 'gameOver'])->name('gameover');

