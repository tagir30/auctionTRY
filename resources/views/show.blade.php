@extends('layouts.app');

@section('content')
    <div class="container">
        <div class="row no-gutters">
            <div class="col-12 col-sm-6 col-md-8">
                <img class="card-img-top"
                     style="height: 500px; width: 500px; display: block;"
                     src="{{asset('/storage/' . $lot->pathImage)}}"
                     data-holder-rendered="true">
            </div>
            <div class="col-6 col-md-4">
                <h2>Название лота: {{$lot->name}}</h2>
                <h2>Описание лота: {{$lot->description}}</h2>
                <h2>Начальная ставка: {{$lot->startingPrice}}</h2>{{--Формат..--}}
                <h2>Время выставления: {{$lot->timeLeft}}</h2>
                <form action="{{route('lots.destroy', ['lot' => $lot->id])}}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit">Удалить лот</button>
                </form>
            </div>
        </div>

        {{--        <timer-component></timer-component>--}}
    </div>



@endsection
