@extends('layouts.app')

@section('content')
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                       <h1 class="text-center">Bulls and Cows</h1>

                        <div class="text-center">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> How to play
                            </button>
                            <br><br>
                        </div>
                        @if (Auth::check())
                            <div class="text-center">
                                <a class="btn btn-primary"href="{{ route('start') }}">{{ __('New game') }}</a>
                            </div>
                        @else
                                <h3 class="text-center">Login or register to start new game</h3>
                        @endif
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Bulls and Cows</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                     <p>
                                         Bulls and Cows (also known as Cows and Bulls or Pigs and Bulls) is a code-breaking mind or paper and pencil game for two or more players. The game is played in turns by two opponents who aim to decipher the other's secret code by trial and error.

                                         Bulls and Cows predates the commercially marketed board game version, Mastermind and the word-based version predates the hit word game Wordle. A version known as MOO was widely available for early mainframe computers, Unix and Multics systems, among others.

                                         The numerical version
                                         The numerical version of the game is usually played with 4 digits, but can be played with any number of digits.

                                         On a sheet of paper, the players each write a 4-digit secret number. The digits must be all different. Then, in turn, the players try to guess their opponent's number who gives the number of matches. The digits of the number guessed also must all be different. If the matching digits are in their right positions, they are "bulls", if in different positions, they are "cows". Example:

                                         Secret number: 4271
                                         Opponent's try: 1234
                                         Answer: 1 bull and 2 cows. (The bull is "2", the cows are "4" and "1".)
                                         The first player to reveal the other's secret number wins the game.

                                         The game may also be played by two teams of players, with the team members discussing their strategy before selecting a move.

                                         Computer versions of the game started appearing on mainframes in the 1970s. The first known version was written by Frank King at the Cambridge Computer Laboratory sometime before the summer of 1970.[1] This version ran on Cambridge's multi-user operating system on their Titan machine. It became so popular the administrators had to introduce systems to prevent it from clogging the system.[2] In 1972, the original Cambridge MOO was ported to the Multics operating system at MIT,[1] and early Unix at AT&T.[3]

                                         A version called BASIC MOO was published in the DECUS Program Library for PDP computers and another was available through the DEC Users Society, both dating from 1971.[4][5] A version written by Lane Hauck in the language FOCAL for the PDP-8 later served as the basis for the handheld game Comp IV by Milton Bradley.[6][7]

                                         These programs maintained a league table of players' scores, and protecting the integrity of this league table became a popular case study for researchers into computer security.[8]

                                         It is proved that any number can be solved within seven turns. The average minimal game length is 26274/5040 ≈ 5.21 turns.[9][10]

                                         The word version
                                         This version is usually played orally, but is easier to play if each player (or each team) keeps written notes. It is exactly like the numerical version, except instead of 4-digit numbers, 4-letter words are used. They must be real words, according to whatever language or languages you are playing the game in. Alternative versions of the game can be played with 3-letter or 5-letter words, but the 4-letter version remains the most popular one.

                                         The game play for the word version is as follows.

                                         One player (the Host) thinks of an isogram word (i.e. no letter appears twice) and, if the word length is not pre-determined, announces the number of letters in the word.
                                         Other players (the Guessers) try to figure out that word by guessing isogram words containing the same number of letters.
                                         The Host responds with the number of Cows & Bulls for each guessed word. As with the digit version, "Cow" means a letter in the wrong position and "Bull" means a letter in the right position.
                                         For example, if the secret word is HEAT, a guess of COIN would result in "0 Bulls, 0 Cows" (none of the guessed letters are present); a guess of EATS would result in "0 Bulls, 3 Cows" (since E, A, T are all present, but in the wrong positions from the guess), and a guess of TEAL would result in "2 Bulls, 1 Cow" (since E and A are in the right positions, while T is in the wrong position). The game continues until one of the Guessers scores "4 Bulls" for guessing HEAT exactly.

                                         The word version of Bulls and Cows was later adapted to Wordle, a web-based word game released in 2021 which almost immediately became a popular social media sensation. Players have six attempts to guess a five-letter word.
                                     </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h1>Top 10</h1>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Username</th>
                                    <th>Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($formattedResults as $result)
                                    <tr>
                                        <td>{{ $result['user_id'] }}</td>
                                        <td>{{ $result['username'] }}</td>
                                        <td>{{ $result['time'] }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
