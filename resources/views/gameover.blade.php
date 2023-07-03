@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center"><h1>Welcome {{ auth()->user()->name }}</h1></div>

                    <div class="card-body text-center">
                        <h1>Game Over</h1>
                        <p>Your your time {{ $elapsedTime }}</p>
                        <a class="btn btn-primary" href="/start">Play Again</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
