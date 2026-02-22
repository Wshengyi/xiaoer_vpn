@extends('layouts.app', ['title' => '注册 - 小二Cloud'])

@section('content')
<div class="card" style="max-width:560px;margin:20px auto;">
    <h2>用户注册</h2>

    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <label class="label">昵称</label>
        <input name="name" class="input" value="{{ old('name') }}" required>

        <label class="label">邮箱</label>
        <input name="email" type="email" class="input" value="{{ old('email') }}" required>

        <label class="label">密码</label>
        <input type="password" name="password" class="input" required>

        <label class="label">确认密码</label>
        <input type="password" name="password_confirmation" class="input" required>

        @if($errors->any())
            <p class="notice" style="color:#ff9b9b">{{ $errors->first() }}</p>
        @endif

        <button class="btn" type="submit">注册并登录</button>
    </form>
</div>
@endsection
