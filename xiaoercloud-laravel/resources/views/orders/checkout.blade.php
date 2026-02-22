@extends('layouts.app', ['title' => '确认下单 - 小二Cloud'])

@section('content')
<div class="card" style="max-width:720px;margin:20px auto;">
    <h2>确认下单</h2>
    <div class="kv"><span>套餐</span><strong>{{ $plan->name }}</strong></div>
    <div class="kv"><span>价格</span><strong>¥{{ $plan->price }}/{{ $plan->cycle }}</strong></div>
    <div class="kv"><span>流量</span><strong>{{ $plan->traffic_gb }}GB</strong></div>

    <form method="POST" action="{{ route('orders.store', $plan) }}" style="margin-top:16px;">
        @csrf
        <button class="btn" type="submit">提交订单</button>
    </form>
</div>
@endsection
