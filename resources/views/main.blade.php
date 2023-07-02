@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                       <h1 class="text-center">Bulls and Cows</h1>
                        @if (Auth::check())
                            <div class="text-center">
                                <a class="btn btn-primary"href="{{ route('start') }}">{{ __('New game') }}</a>
                            </div>
                        @else
                                <h3 class="text-center">Login or register to start new game</h3>
                        @endif
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
