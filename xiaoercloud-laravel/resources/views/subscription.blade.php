@extends('layouts.app', ['title' => '订阅链接 - 小二Cloud'])

@section('content')
<div class="topbar"><div class="logo">订阅链接中心</div><a class="btn ghost" href="{{ route('dashboard') }}">返回用户中心</a></div>

@if(!$subscription)
    <div class="card">暂无订阅数据。</div>
@else
<div class="card">
    <p class="notice">套餐：{{ $subscription->plan->name }}（¥{{ $subscription->plan->price }}/{{ $subscription->plan->cycle }}）</p>

    <div class="card" style="margin-top:10px">
        <div class="label">Clash 订阅</div>
        <code class="code">{{ $subscription->clash_url }}</code>
    </div>

    <div class="card" style="margin-top:10px">
        <div class="label">Shadowrocket 订阅</div>
        <code class="code">{{ $subscription->shadowrocket_url }}</code>
    </div>
</div>
@endif
@endsection
