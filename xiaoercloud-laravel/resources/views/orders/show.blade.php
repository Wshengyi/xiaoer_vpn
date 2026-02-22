@extends('layouts.app', ['title' => '订单详情 - 小二Cloud'])

@section('content')
<div class="card" style="max-width:800px;margin:20px auto;">
    <h2>订单详情</h2>
    <div class="kv"><span>订单号</span><strong>{{ $order->order_no }}</strong></div>
    <div class="kv"><span>套餐</span><strong>{{ $order->plan->name }}</strong></div>
    <div class="kv"><span>金额</span><strong>¥{{ number_format($order->amount,2) }}</strong></div>
    <div class="kv"><span>状态</span><strong>{{ $order->status }}</strong></div>

    @if($order->status !== '已支付')
    <form method="POST" action="{{ route('orders.pay', $order) }}" style="margin-top:16px;">
        @csrf
        <button class="btn" type="submit">模拟支付成功</button>
    </form>
    @else
    <p class="notice" style="margin-top:12px;">已支付成功，可回用户中心查看订阅。</p>
    @endif
</div>
@endsection
