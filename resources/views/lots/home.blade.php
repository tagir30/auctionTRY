@extends('layouts.app')


@section('content')
    <div class="container">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session()->has('success_message'))
            <div class="spacer"></div>
            <div class="alert alert-success">
                {{ session()->get('success_message') }}
            </div>
        @endif

        <div class="text-center">
            <a href="{{route('lots.create')}}">
                <button class="btn btn-dark btn-lg">Созадть новый лот</button>
            </a>
        </div>
        <br>
        @isset($lots)
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
                                <h3>{{$lot->startingPrice}} рублей</h3>
                                <h3>{{$lot->timeLeft}}</h3>
                                <p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <form action="{{route('lots.update', ['lot' => $lot->id])}}" method="post">
                                            @csrf
                                            @method('PATCH')
                                        @if(!$lot->status)

                                                <input type="hidden" name="action" value = "addToAuction">
                                                    <button type="submit" onclick="return confirm('Вы уверены?')" class="btn btn-danger">
                                                        Выставить на аукцион
                                                    </button>
                                                <a href="{{route('lots.show', ['lot' => $lot->id])}}">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                                </a>
                                        @else
                                                <input type="hidden" name="action" value="removeFromAuction">
                                                <button type="submit" onclick="return confirm('Вы уверены?')" class="btn btn-danger">
                                                    Снять с аукциона
                                                </button>
                                        @endif
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endisset
    </div>
@endsection
