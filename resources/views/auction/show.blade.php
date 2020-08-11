@extends('layouts.app')

@section('content')

    <lot-show-component :lot="{{$lot}}"></lot-show-component>
    {{--    <div class="container">--}}
{{--        <div class="row no-gutters">--}}
{{--            <div class="col-12 col-sm-6 col-md-5">--}}
{{--                <img class="card-img-top"--}}
{{--                     style="height: 300px; width: 300px; display: block;"--}}
{{--                     src="{{asset('/storage/' . $lot->pathImage)}}"--}}
{{--                     data-holder-rendered="true">--}}
{{--            </div>--}}

{{--            <div class="col-md-7">--}}
{{--                <ul class="list-group">--}}
{{--                    <li class="list-group-item">Название: {{$lot->name}}</li>--}}
{{--                    <li class="list-group-item">Описание: {{$lot->description}}</li>--}}
{{--                    <li class="list-group-item">Актуальная ставка: {{$lot->offer->bet_on_lot}}</li>--}}
{{--                    <li class="list-group-item">Дата окончания торгов: {{$lot->timeLeft}}</li>--}}

{{--                </ul>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
