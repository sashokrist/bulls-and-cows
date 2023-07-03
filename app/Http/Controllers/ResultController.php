<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $results = Game::with('user')->orderBy('time')->take(10)->get();

        return view('main', compact('results'));
    }
}
