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
        <form action="{{route('home.store')}}" method="post">
            @csrf
            <input type="text" name="lot[nameLot]" placeholder="Название лота"><br>
            <input type="text" name="lot[description]"><br>
            <input type="text" name="lot[startingPrice]" placeholder="Стартовая цена"><br>
            <input type="text" name="lot[timeLeft]"><br>
            <input type="file" name="lot[image]"><br>
            <input type="submit" value="Отправить">
        </form>
    </div>
</body>
</html>
