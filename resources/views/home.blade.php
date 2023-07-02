@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
                @if ($errors->has('guess'))
                    <div class="alert alert-danger">
                        {{ $errors->first('guess') }}
                    </div>
                @endif
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h1>Welcome to Bulls and Cows Game!</h1>
                        <form action="{{ route('guess') }}" method="POST">
                            @csrf
                            <label for="guess">Enter your guess:</label>
                            <input type="text" id="guess" name="guess">
                            <button class="btn btn-primary" type="submit">Guess</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
