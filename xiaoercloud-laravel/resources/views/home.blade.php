@extends('layouts.app', ['title' => '小二Cloud'])

@section('content')
<section class="hero">
    <h1>快，触手可及</h1>
    <p class="sub">Laravel + MySQL 架构的 MVP，先跑通订阅售卖与订阅交付核心流程（Clash / Shadowrocket）。</p>
</section>

<section class="grid">
    @foreach($plans as $plan)
        <div class="card plan">
            <h3>{{ $plan->name }}</h3>
            <div class="kv"><span>价格</span><strong>¥{{ $plan->price }}/{{ $plan->cycle }}</strong></div>
            <div class="kv"><span>流量</span><strong>{{ $plan->traffic_gb }}GB</strong></div>
            <div class="kv"><span>客户端</span><strong>Clash / Shadowrocket</strong></div>
            <div style="margin-top:10px">
                @auth
                    <a class="btn" href="{{ route('orders.checkout', $plan) }}">立即下单</a>
                @else
                    <a class="btn" href="{{ route('login') }}">登录后购买</a>
                @endauth
            </div>
        </div>
    @endforeach

    <div class="card plan">
        <h3>立即体验</h3>
        <p class="notice">演示账号：demo@xiaoercloud.local / 123456</p>
        <a class="btn" href="{{ route('login') }}">进入用户中心</a>
    </div>
</section>
@endsection
