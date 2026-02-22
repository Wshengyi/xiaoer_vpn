@extends('layouts.app', ['title' => '登录 - 小二Cloud'])

@section('content')
<div class="card" style="max-width:560px;margin:20px auto;">
    <h2>用户登录</h2>
    <p class="notice">演示账号：demo@xiaoercloud.local / 123456</p>

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <label class="label">邮箱</label>
        <input name="email" class="input" value="{{ old('email', 'demo@xiaoercloud.local') }}" required>

        <label class="label">密码</label>
        <input type="password" name="password" class="input" value="123456" required>

        @error('email')
        <p class="notice" style="color:#ff9b9b">{{ $message }}</p>
        @enderror

        <button class="btn" type="submit">登录</button>
    </form>
</div>
@endsection
