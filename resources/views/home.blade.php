@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                      <a href="{{$link}}">
                        <h3>{{$title}}</h3>
                        <p style="text-align: justify">{{htmlspecialchars_decode($description)}}</p>
                      </a>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                                            @foreach ($array as $count=>$value)
                                                @if (is_array($value))

                               <a href="{{$value['link']}}">
                                <h5 class="card-title">{{$value['title']}}</h5>
                                                    <p style="text-align: justify">{{htmlspecialchars_decode($value['description'])}}</p>
                               </a>

                            @endif
                        @endforeach
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

     </div>



@endsection
