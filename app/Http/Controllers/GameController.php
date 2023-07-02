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
//dd($randomNumber['number']);
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
        $str = '0123456789';
        $number = '';
        $arr = array_fill(0, 10, 0);
        for ($i = 1; $i <= 4; $i++) {
            $rand = rand(0, strlen($str)-1);
            $number .= $str[$rand];
            $arr[$str[$rand]] = $i;
            $str = str_replace($str[$rand], '', $str);
        }
        return ['number' => $number];
    }
    public function guess(Request $request)
    {
        $playerGuess = $request->input('guess');
        $randomNumber = session('randomNumber');

       //\\ dd($randomNumber);

        // Check the limitations
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

// Helper method to check the digit limitations
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


    // Helper method to calculate the number of bulls
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

    // Helper method to calculate the number of cows
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
        // Render the result view without any data
        return view('result');
    }

//    public function gameover()
//    {
//        $startTime = session('startTime');
//        $endTime = now();
//        $elapsedTime = $startTime->diffInSeconds($endTime);
//
//        $game = Game::where('user_id', auth()->user()->id)->latest()->first();
//        $game->time = $elapsedTime;
//        $game->save();
//
//
//        // Clear the session variables
//        session()->forget(['randomNumber', 'startTime']);
//        return view('gameover')->with(['elapsedTime' => $elapsedTime]);
//    }
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
