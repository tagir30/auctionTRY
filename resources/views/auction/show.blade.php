@extends('layouts.app')

@section('content')

    <lot-show-component :lot="{{$lot}}" :user_id="@json(auth()->id())" :auth = "@json(auth()->check())"></lot-show-component>
    <br>
    <div class="container">
        @comments(['model' => $lot])
    </div>

@endsection
