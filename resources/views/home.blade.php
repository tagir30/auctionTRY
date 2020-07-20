@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            @foreach($lots as $lot)
                <div class="col-md-8">
                    <h1>{{$lot->name}}</h1>
                    <h2>{{$lot->description}}</h2>
                    <h3>{{$lot->startingPrice}} рублей</h3>
                    <h3>{{$lot->timeLeft}} часов</h3>
                </div>
            @endforeach
        </div>

        <div>
            <a href="{{route('home.create')}}"><button>Созадть новый лот</button></a>
        </div>
    </div>
@endsection
