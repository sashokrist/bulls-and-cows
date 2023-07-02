@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">


            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Welcome {{ auth()->user()->name }}</div>

                    <div class="card-body">
                        <div>
                            <form action="{{ route('guess') }}" method="POST">
                                @csrf
                                <label for="guess">Enter your guess:</label>
                                <input type="text" id="guess" name="guess">
                                <button class="btn btn-primary" type="submit">Guess</button>
                            </form>
                        </div>
                        <h1>Result</h1>
                        <!-- user.blade.php -->

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Guess</th>
                                <th>Bulls</th>
                                <th>Cows</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($results as $result)
                                <tr>
                                    <td>{{ $result->userGuess }}</td>
                                    <td>{{ $result->bulls }}</td>
                                    <td>{{ $result->cows }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <a class="btn btn-primary" href="/">Give up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
