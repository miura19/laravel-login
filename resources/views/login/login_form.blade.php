<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ログインフォーム</title>
    <script src="{{ asset('js/app.js')}}" defer></script>
    <link href="{{ asset('css/app.css')}}" rel="stylesheet">
    <link href="{{ asset('css/signin.css')}}" rel="stylesheet">
</head>
<body>

<form class="form-signin" method="POST" action="{{ route('login')}}">
    @csrf
    <h1 class="h3 mb-3 font-weight-normal">ログインフォーム</h1>
    <x-alert type="danger" :session="session('login_error')"/>
    <x-alert type="danger" :session="session('logout')"/>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address">
    @if ($errors->has('email'))
        <div class="alert alert-danger">
            <li>{{$errors->first('email')}}</li>
        </div>
    @endif
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password">
    @if ($errors->has('password'))
        <div class="alert alert-danger">
            <li>{{$errors->first('password')}}</li>
        </div>
    @endif
    <button class="btn btn-lg btn-primary btn-block btn-width" type="submit">ログイン</button>
</form>

</body>
</html>