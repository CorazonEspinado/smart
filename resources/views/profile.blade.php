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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">


                           @foreach ($channels as $channel)
                               <input type="checkbox" value="{{$channel->id}}" name="channel[]" id="channel" checked>{{$channel->channel_name}}
                               @endforeach
                        <button type="button" id="save_channels">Saglabāt</button>

                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">

@foreach($postArray as $count=>$array)
<h3 style="color: red">{{$array['channel']['title']}}</h3>
    @foreach ($array as $arr)
        <a href="{{$arr['item']['link']}}">
           <h3>{{$arr['item']['title']}}</h3>
    <p style="text-align: justify">{{htmlspecialchars_decode($arr['item']['description'])}}</p>
        </a>
                       @foreach ($arr['item'] as $itemCount=>$item)
                          @if (is_numeric($itemCount))
                    <a href="{{$item['link']}}">
                     <h3>{{$item['title']}}</h3>
                              <p>{{$item['description']}}</p>
                    </a>
                                    @endif

                           @endforeach
        @endforeach

    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
