@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach($lots as $lot)
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top"
                             style="height: 225px; width: 100%; display: block;"
                             src="{{asset('/storage/' . $lot->pathImage)}}"
                             data-holder-rendered="true">
                        <div class="card-body">
                            <p class="card-text">
                            <h1>{{$lot->name}}</h1>
                            <h2>{{$lot->description}}</h2>
                            <h3>{{$lot->startingPrice}} рублей</h3>{{--Изменять на актуальную--}}
                            <h3>{{$lot->timeLeft}} часов</h3>{{--Желательно динамически показывать :(--}}
                            <p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn-danger">
                                        Сделать быструю ставку
                                    </button>
                                </div>

                                <div class="btn-group">
                                    <a href="{{route('offers.show', ['offer' => $lot->id])}}"></a>
                                    <button type="button" class="btn-danger">
                                        Посмотреть поближе :В
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
