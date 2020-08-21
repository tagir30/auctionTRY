@extends('layouts.app');

@section('content')
    <div class="container">
        <div class="row no-gutters">
            <div class="col-12 col-sm-6 col-md-5">
                <img class="card-img-top"
                     style="height: 300px; width: 300px; display: block;"
                     src="{{asset('/storage/' . $lot->pathImage)}}"
                     data-holder-rendered="true">
            </div>

            <div class="col-md-7">

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{route('lots.update', ['lot' => $lot->id])}}" method="post"
                      enctype="multipart/form-data">
                    @method('patch')
                    @csrf
{{--                    <input type="hidden" name="action" value="update">--}}
                    <div class="mb-3">
                        <label>Название лота</label>
                        <div class="input-group">
                            <input type="text" name="lot[name]" placeholder="Название лота" value="{{$lot->name}}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Описание лота</label>
                        <div class="input-group">
                            <input type="text" name="lot[description]" placeholder="Описание лота"
                                   value="{{$lot->description}}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Начальная цена</label>
                        <div class="input-group">
                            <input type="text" name="lot[startingPrice]" placeholder="Начальная цена"
                                   value="{{$lot->startingPrice}}"><br>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Дата закрытия торгов</label>
                        <div class="input-group">
                            <input type="date" name="lot[timeLeft]" value="{{$lot->timeLeft}}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Фото товара</label>
                        <div class="input-group">
                            <input type="file" name="lot[image]" value="{{$lot->pathImage}}"><br>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="input-group">
                            <button type="submit">Изменить</button>
                        </div>
                    </div>
                </form>
                    @if(!$lot->status)
                    <div class="mb-3">
                        <div class="input-group">
                            <form action="{{route('lots.destroy', ['lot' => $lot->id])}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger" onclick="return confirm('Вы уверены?')">Удалить лот</button>
                            </form>
                        </div>
                    </div>
                    @endif
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <form action="{{route('lots.update', ['lot' => $lot->id])}}" method="post" hidden>
                        @csrf
                        @method('PATCH')
                    </form>
                </div>
            </div>

        </div>
@endsection
