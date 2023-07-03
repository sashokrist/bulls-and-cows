<?php

namespace App\Services;

class GameService
{
    public function startGame()
    {
        if (!session()->has('startTime')) {
            session(['startTime' => now()]);
        }
    }

    public function generateRandomNumber()
    {
        do {
            $digits = range(0, 9);
            shuffle($digits);

            $guess = implode('', array_slice($digits, 0, 4));
            $guess = strval($guess);
            $generatingNumber = true;
            $i = 0;
            $validNumber = true;
            while ($i < strlen($guess)) {
                $digit = $guess[$i];
                if ($digit === '4' || $digit === '5') {
                    if ($i % 2 === 0) {
                        // Invalid position for digit 4 or 5, regenerate number
                        $validNumber = false;
                        break;
                    }
                }
                $i++;
            }

            if ($validNumber) {
                // Valid number generated, stop generating numbers
                $generatingNumber = false;
            }
        } while ($generatingNumber);

        $numberEight = strpos((string)$guess, "8");
        $numberOne = strpos((string)$guess, "1");

        $numberOne = strpos((string)$guess, "1");

        if ($numberEight !== false && $numberOne !== false && abs($numberEight - $numberOne) !== 1) {
            $numbersDifferentThanOneAndEight = str_replace(['1', '8'], '', $guess);
            $guess = '18' . $numbersDifferentThanOneAndEight;
        }

        return ['number' => $guess];
    }

    public function calculateBulls($guess, $target)
    {
        $bulls = 0;
        for ($i = 0; $i < 4; $i++) {
            if ($guess[$i] === $target[$i]) {
                $bulls++;
            }
        }
        return $bulls;
    }

    public function calculateCows($guess, $target)
    {
        $cows = 0;
        for ($i = 0; $i < 4; $i++) {
            if (in_array($guess[$i], str_split($target)) && $guess[$i] !== $target[$i]) {
                $cows++;
            }
        }
        return $cows;
    }
}
