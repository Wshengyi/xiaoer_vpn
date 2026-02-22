<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? '小二Cloud' }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container">
    <div class="nav">
        <div class="logo">小二Cloud</div>
        @auth
            <div class="actions">
                <a class="btn ghost" href="{{ route('dashboard') }}">用户中心</a>
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn ghost" type="submit">退出</button></form>
            </div>
        @else
            <div class="actions">
                <a class="btn ghost" href="{{ route('login') }}">登录</a>
                <a class="btn ghost" href="{{ route('register') }}">注册</a>
            </div>
        @endauth
    </div>

    @yield('content')
</div>
</body>
</html>
