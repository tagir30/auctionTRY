@extends('layouts.app')

@section('content')
    <div class="container">
            <div class="row">

                <lots-component :auth="@json(auth()->check())" :user_id = "@json(auth()->id())"></lots-component>{{--Без тернарки не работает--}}
            </div>
    </div>
@endsection
