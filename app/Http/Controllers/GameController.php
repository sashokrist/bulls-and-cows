<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuessRequest;
use App\Models\Game;
use App\Models\Result;
use App\Services\GameService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Throwable;

class GameController extends Controller
{
    private $gameService;

    public function __construct(GameService $gameService)
    {
        $this->middleware('auth');
        $this->gameService = $gameService;
    }

    public function start()
    {
        Game::create([
            'user_id' => auth()->id(),
            'time' => now(),
        ]);

        $this->gameService->startGame();

        $randomNumber = $this->gameService->generateRandomNumber();
        session(['randomNumber' => $randomNumber['number']]);

        return view('home');
    }

    public function guess(GuessRequest $request)
    {
        $playerGuess = $request->input('guess');
        $randomNumber = session('randomNumber');

        $bulls = $this->gameService->calculateBulls($playerGuess, $randomNumber);
        $cows = $this->gameService->calculateCows($playerGuess, $randomNumber);

        if ($bulls === 4) {
            return redirect('gameover');
        }

        $game = Game::where('user_id', auth()->user()->id)->latest()->first();
        try {
            $result = new Result();
            $result->game_id = $game->id;
            $result->userGuess = $playerGuess;
            $result->bulls = $bulls;
            $result->cows = $cows;
            $result->save();

        } catch (Throwable $e) {
            Log::critical($e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('start')->withInput()->withErrors(['guess' => 'Invalid input, try again!']);
        }

        $results = Result::where('game_id', $game->id)->orderByDesc('id')->get();

        return view('result')->with(['results' => $results]);
    }

    public function gameover()
    {
        $startTime = session('startTime');
        $endTime = now();
        $elapsedTime = $startTime->diffInSeconds($endTime);

        $game = Game::where('user_id', auth()->user()->id)->latest()->first();
        $game->time = gmdate('H:i:s', $elapsedTime); // Format $elapsedTime as HH:MM:SS
        $game->save();

        // Clear the session variables
        session()->forget(['randomNumber', 'startTime']);

        return view('gameover')->with(['elapsedTime' => $elapsedTime]);
    }
}
