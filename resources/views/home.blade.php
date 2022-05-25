<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css')}}" rel="stylesheet">
    <title>ホーム画面</title>
</head>
<body>
    <div class="container">
        <div class="mt-5">
            {{-- @if (session('login_success'))
                <div class="alert alert-success">
                    {{ session('login_success')}}
                </div>
            @endif --}}
            <x-alert type="success" :session="session('login_success')"/>
            <h3>プロフィール</h3>
            <ul>
                <li>名前：{{ Auth::user()->name }}</li>
                <li>メールアドレス：{{ Auth::user()->email }}</li>
            </ul>
        </div>
        <form action="{{ route('logout')}}" method="POST">
            @csrf
            <button class="btn btn-danger">ログアウト</button>
        </form>
    </div>
</body>
</html>