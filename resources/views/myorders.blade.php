<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyOrders</title>
</head>
<body>
    <h1>Siparişlerim</h1>
    @if(isset($success))
        <p>{{$success}}</p>
    @endif
    @if(isset($error))
        <p>{{$error}}</p>
    @endif
    <a href="{{route('main')}}">Ana Sayfaya Dön</a>
</body>
</html>