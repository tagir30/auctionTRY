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
                <h2>Дата окончания торгов: {{$lot->timeLeft}}</h2>
                <form action="{{route('lots.destroy', ['lot' => $lot->id])}}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit">Удалить лот</button>
                </form>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <form action="{{route('lots.update', ['lot' => $lot->id])}}" method="post">
                            @csrf
                            @method('PATCH')
                            @if(!$lot->status)
                                <input type="hidden" name="addToAuction">
                                <button type="submit" onclick="return confirm('Вы уверены?')" class="btn btn-danger">
                                    Выставить на аукцион
                                </button>
                            @else
                                <input type="hidden" name="lotRemove">
                                <button type="submit" onclick="return confirm('Вы уверены?')" class="btn btn-danger">
                                    Снять с аукциона
                                </button>
                        @endif
            </div>
        </div>

        {{--        <timer-component></timer-component>--}}
    </div>



@endsection
