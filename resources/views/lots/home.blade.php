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

        <a class="text-info" href="{{route('lots.index', ['sort' => 'active'])}}">||Активные лоты ||</a>
        <a class="text-danger" href="{{route('lots.index', ['sort' => 'end'])}}">Завершённые лоты ||</a>
        <a class="text-body" href="{{route('lots.index')}}">Все лоты ||</a>


        <div class="text-center">
            <a href="{{route('lots.create')}}">
                <button class="btn btn-dark btn-lg">Созадть новый лот</button>
            </a>
        </div>
        <br>
        @isset($lots)
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Фото</th>
                        <th>Название лота</th>
                        <th>Описание</th>
                        <th>Начальная ставка</th>
                        <th>Дата закрытия ставок</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lots as $lot)
                        <tr>
                            <td>
                                <a href="{{route('lots.show', $lot->id)}}">
                                    <img data-holder-rendered="true"
                                         src="{{asset('/storage/' . $lot->pathImage)}}"
                                         style="height: 90px; width: 90px; display: block;">
                                </a>
                            </td>
                            <td>{{$lot->name}}</td>
                            <td>{{$lot->short_description}}</td>
                            <td>{{$lot->startingPrice}} рублей</td>
                            <td>{{$lot->timeLeft}}</td>
                            <td>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <form action="{{route('lots.updateStatus')}}" method="post">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="lot" value="{{$lot->id}}">
                                            @if(!$lot->status)

                                                <input type="hidden" name="action" value="addToAuction">
                                                <button type="submit" onclick="return confirm('Вы уверены?')"
                                                        class="btn btn-danger btn-sm">
                                                    Выставить на аукцион
                                                </button>
                                                <a href="{{route('lots.show', ['lot' => $lot->id])}}">
                                                    <button type="button" class="btn btn-sm btn-primary">
                                                        Редактировать
                                                    </button>
                                                </a>
                                            @else
                                                <input type="hidden" name="action" value="removeFromAuction">
                                                <button type="submit" onclick="return confirm('Вы уверены?')"
                                                        class="btn btn-danger btn-sm">
                                                    Снять с аукциона
                                                </button>
                                            @endif
                                        </form>

                                    </div>
                                </div>
{{--                                <a href="{{route('lots.show', [$lot->id])}}">--}}
{{--                                    <button class="btn btn-primary btn-sm">Редактировать</button>--}}
{{--                                </a>--}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{--            <div class="row">--}}
            {{--                @foreach($lots as $lot)--}}
            {{--                    <div class="col-md-4">--}}
            {{--                        <div class="card mb-4 box-shadow">--}}
            {{--                            <img class="card-img-top"--}}
            {{--                                 style="height: 225px; width: 100%; display: block;"--}}
            {{--                                 src="{{asset('/storage/' . $lot->pathImage)}}"--}}
            {{--                                 data-holder-rendered="true">--}}
            {{--                            <div class="card-body">--}}
            {{--                                <p class="card-text">--}}
            {{--                                <h1>{{$lot->name}}</h1>--}}
            {{--                                <h2>{{$lot->short_description}}</h2>--}}
            {{--                                <h3>{{$lot->startingPrice}} рублей</h3>--}}
            {{--                                <h3>{{$lot->timeLeft}}</h3>--}}
            {{--                                <p>--}}
{{--                                            <div class="d-flex justify-content-between align-items-center">--}}
{{--                                                <div class="btn-group">--}}
{{--                                                    <form action="{{route('lots.updateStatus')}}" method="post">--}}
{{--                                                        @csrf--}}
{{--                                                        @method('PATCH')--}}
{{--                                                        <input type="hidden" name="lot" value="{{$lot->id}}">--}}
{{--                                                        @if(!$lot->status)--}}

{{--                                                            <input type="hidden" name="action" value="addToAuction">--}}
{{--                                                            <button type="submit" onclick="return confirm('Вы уверены?')"--}}
{{--                                                                    class="btn btn-danger">--}}
{{--                                                                Выставить на аукцион--}}
{{--                                                            </button>--}}
{{--                                                            <a href="{{route('lots.show', ['lot' => $lot->id])}}">--}}
{{--                                                                <button type="button" class="btn btn-sm btn-outline-secondary">--}}
{{--                                                                    Edit--}}
{{--                                                                </button>--}}
{{--                                                            </a>--}}
{{--                                                        @else--}}
{{--                                                            <input type="hidden" name="action" value="removeFromAuction">--}}
{{--                                                            <button type="submit" onclick="return confirm('Вы уверены?')"--}}
{{--                                                                    class="btn btn-danger">--}}
{{--                                                                Снять с аукциона--}}
{{--                                                            </button>--}}
{{--                                                        @endif--}}
{{--                                                    </form>--}}

{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
            {{--                    </div>--}}
            {{--                @endforeach--}}
            {{--            </div>--}}
            {{--            {{$lots->links()}}--}}
        @endisset
    </div>
@endsection
