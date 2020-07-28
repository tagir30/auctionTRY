@extends('layouts.app')

@section('content')
    <body>
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

        <form action="{{route('lots.store')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="Lot">Название лота</label>
                <div class="input-group">
                    <input type="text" name="lot[nameLot]" placeholder="Название лота" value="{{old('lot.nameLot')}}">
                </div>
            </div>
            <div class="mb-3">
                <label for="Lot">Описание лота</label>
                <div class="input-group">
                    <input type="text" name="lot[description]" placeholder="Описание лота"
                           value="{{old('lot.description')}}">
                </div>
            </div>
            <div class="mb-3">
                <label for="Lot">Начальная цена</label>
                <div class="input-group">
                    <input type="text" name="lot[startingPrice]" placeholder="Начальная цена"
                           value="{{old('lot.startingPrice')}}"><br>
                </div>
            </div>
            <div class="mb-3">
                <label for="Lot">Время на которое выставить лот</label>
                <div class="input-group">
                    <input type="text" name="lot[timeLeft]" value="{{old('lot.timeLeft')}}"><br>
                </div>
            </div>
            <div class="mb-3">
                <label for="Lot">Фото товара</label>
                <div class="input-group">
                    <input type="file" name="lot[image]"><br>
                </div>
            </div>
            <div class="mb-3">
                <div class="input-group">
                    <input type="submit" value="Отправить">
                </div>
            </div>


        </form>

    </div>
    </body>
    </html>
@endsection


