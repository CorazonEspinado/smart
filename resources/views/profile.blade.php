@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        @if ($user->avatar)
                            <p><img src="{{$user->avatar}}" height="100" width="100"></p>
                        @endif
                        @if ($user->name)
                            <p>Name: {{$user->name}}</p>
                        @endif
                        <p>Email: {{$user->email}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
