<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GameController extends Controller
{
    public function start()
    {
        $newGame = new Game();
        $newGame->user_id = auth()->user()->id;
        $newGame->time = now();
        $newGame->save();

        $this->startGame();

        $randomNumber = $this->generateRandomNumber();
        session(['randomNumber' => $randomNumber['number']]);

        return view('home');
    }

    private function startGame()
    {
        if (!session()->has('startTime')) {
            session(['startTime' => now()]);
        }
    }

    private function generateRandomNumber()
    {
        $number = '';
        $arr = array_fill(0, 10, 0);
        $usedDigits = array();

        for ($i = 1; $i <= 4; $i++) {
            $availableDigits = array_diff(range(0, 9), $usedDigits);

            // Ensure digits 1 and 8 are right next to each other
            if (($i == 2 && in_array(1, $usedDigits) && !in_array(8, $usedDigits))
                || ($i == 3 && !in_array(1, $usedDigits) && in_array(8, $usedDigits))) {
                $availableDigits = array_intersect($availableDigits, [1, 8]);
            }

            // Ensure digits 4 and 5 are not on even index/position
            if (($i == 2 || $i == 4) && in_array(4, $usedDigits) && in_array(5, $usedDigits)) {
                $availableDigits = array_diff($availableDigits, [4, 5]);
            }

            $randIndex = array_rand($availableDigits);
            $digit = $availableDigits[$randIndex];

            $number .= $digit;
            $usedDigits[] = $digit;
        }

        return ['number' => $number];
    }

    public function guess(Request $request)
    {
        $playerGuess = $request->input('guess');
        $randomNumber = session('randomNumber');

        if (!$this->checkDigitLimitations($playerGuess)) {
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('start')->withInput()->withErrors(['guess' => 'Invalid guess!']);
        }

        $bulls = $this->calculateBulls($playerGuess, $randomNumber);
        $cows = $this->calculateCows($playerGuess, $randomNumber);

        if ($bulls === 4) {
            return redirect('gameover');
        }

        $game = Game::where('user_id', auth()->user()->id)->latest()->first();

        $result = new Result();
        $result->game_id = $game->id;
        $result->userGuess = $playerGuess;
        $result->bulls = $bulls;
        $result->cows = $cows;
        $result->save();

        $results = Result::where('game_id', $game->id)->get();

        return view('result')->with(['results' => $results]);
    }

    private function checkDigitLimitations($guess)
    {
        // Check if digits 1 and 8 are right next to each other
        if (str_contains($guess, '18') || str_contains($guess, '81')) {
            return true;
        }

        // Check if digits 4 and 5 are on even index/position
        for ($i = 0; $i < strlen($guess); $i += 2) {
            if ($guess[$i] === '4' && isset($guess[$i + 1]) && $guess[$i + 1] === '5') {
                return false;
            }
            if ($guess[$i] === '5' && isset($guess[$i + 1]) && $guess[$i + 1] === '4') {
                return false;
            }
        }

        return true;
    }

    private function calculateBulls($guess, $target)
    {
        $bulls = 0;
        for ($i = 0; $i < 4; $i++) {
            if ($guess[$i] === $target[$i]) {
                $bulls++;
            }
        }
        return $bulls;
    }

    private function calculateCows($guess, $target)
    {
        $cows = 0;
        for ($i = 0; $i < 4; $i++) {
            if (in_array($guess[$i], str_split($target)) && $guess[$i] !== $target[$i]) {
                $cows++;
            }
        }
        return $cows;
    }

    public function result()
    {
        return view('result');
    }

    public function gameover()
    {
        $startTime = session('startTime');
        $endTime = now();
        $elapsedTime = $startTime->diffInSeconds($endTime);

        $game = Game::where('user_id', auth()->user()->id)->latest()->first();
        $game->time = (int) $elapsedTime; // Cast $elapsedTime to integer
        $game->save();

        // Clear the session variables
        session()->forget(['randomNumber', 'startTime']);
        return view('gameover')->with(['elapsedTime' => $elapsedTime]);
    }

}
