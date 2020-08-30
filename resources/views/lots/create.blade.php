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

        <form action="{{route('lots.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Название лота</label>
                <div class="input-group">
                    <input type="text" name="lot[name]" placeholder="Название лота" value="{{old('lot.name')}}">
                </div>
            </div>
            <div class="mb-3">
                <label>Описание лота</label>
                <div class="input-group">
                    <textarea type="text" name="lot[description]" placeholder="Описание лота" rows="10" cols="45">
                        {{old('lot.description')}}
                    </textarea>
                </div>
            </div>
            <div class="mb-3">
                <label>Начальная цена</label>
                <div class="input-group">
                    <input type="text" name="lot[startingPrice]" placeholder="Начальная цена"
                           value="{{old('lot.startingPrice')}}"><br>
                </div>
            </div>
            <div class="mb-3">
                <label>Дата закрытия торгов</label>
                <div class="input-group">
                    <input type="date" name="lot[timeLeft]" value="{{old('lot.timeLeft')}}">
                </div>
            </div>
            <div class="mb-3">
                <label>Фото товара</label>
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
@endsection


