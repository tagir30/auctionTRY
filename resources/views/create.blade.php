@extends('layouts.app')

@section('content')
    <!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <form action="{{route('lots.store')}}" method="post">
        @csrf
        <div class="mb-3">
            <label for="Lot">Название лота</label>
            <div class="input-group">
                <input type="text" name="lot[nameLot]" placeholder="Название лота">
            </div>
        </div>
        <div class="mb-3">
            <label for="Lot">Описание лота</label>
            <div class="input-group">
                <input type="text" name="lot[description]" placeholder="Описание лота">
            </div>
        </div>
        <div class="mb-3">
            <label for="Lot">Начальная цена</label>
            <div class="input-group">
                <input type="text" name="lot[startingPrice]" placeholder="Начальная цена"><br>
            </div>
        </div>
        <div class="mb-3">
            <label for="Lot">Время до окончания торгов</label>
            <div class="input-group">
                <input type="text" name="lot[timeLeft]"><br>
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


