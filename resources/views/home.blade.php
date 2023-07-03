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
                    <div class="card-header"><h1 class="text-center">Welcome {{ auth()->user()->name }}</h1></div>
                    <div class="card-body text-center">
                        <form action="{{ route('guess') }}" method="POST">
                            @csrf
                            <label for="guess">Enter your guess:</label>
                            <input type="text" id="guess" name="guess" required>
                            <button class="btn btn-primary" type="submit">Guess</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        setTimeout(function () {
            $('.alert').fadeOut('slow');
        }, 3000);
    </script>
@endsection
