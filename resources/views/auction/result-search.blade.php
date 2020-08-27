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

        @if(count($offers) > 0)
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Фото</th>
                    <th>Название лота</th>
                    <th>Описание</th>
                    <th>Ставка</th>
                    <th>Дата закрытия ставок</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($offers as $offer)
                    <tr>
                        <td>
                            <img data-holder-rendered="true"
                                 src="{{asset('/storage/' . $offer->lot->pathImage)}}"
                                 style="height: 90px; width: 90px; display: block;">
                        </td>
                        <td>{{$offer->lot->name}}</td>
                        <td>{{$offer->lot->description}}</td>
                        <td>{{$offer->bet_on_lot}} рублей</td>
                        <td>{{$offer->lot->timeLeft}}</td>
                        <td><a href="{{route('offers.show', [$offer->id])}}">
                                <button class="btn btn-primary">Посмотреть поближе</button>
                            </a></td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        @else
            <h3>По вашему запросу ничего не найдено!</h3>
        @endif
    </div>

@endsection
