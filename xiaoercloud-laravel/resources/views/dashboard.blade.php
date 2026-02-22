@extends('layouts.app', ['title' => '用户中心 - 小二Cloud'])

@section('content')
<div class="topbar"><div class="logo">用户中心</div><a class="btn ghost" href="{{ route('subscription') }}">订阅链接中心</a></div>

@if(!$subscription)
    <div class="card">暂无订阅数据。</div>
@else
    @php
        $total = $subscription->plan->traffic_gb;
        $used = (float)$subscription->used_upload_gb + (float)$subscription->used_download_gb;
        $remaining = max(0, $total - $used);
    @endphp

    <section class="grid">
        <div class="card plan"><div class="label">订阅状态</div><div class="stat ok">{{ $subscription->status }}</div></div>
        <div class="card plan"><div class="label">下次扣费</div><div class="stat">{{ optional($subscription->next_billing_date)->toDateString() }}</div></div>
        <div class="card panel">
            <h3>{{ $subscription->plan->name }}</h3>
            <div class="kv"><span>价格</span><strong>¥{{ $subscription->plan->price }}/{{ $subscription->plan->cycle }}</strong></div>
            <div class="kv"><span>剩余流量</span><strong>{{ number_format($remaining,2) }}GB / {{ number_format($total,2) }}GB</strong></div>
            <div class="kv"><span>已用流量</span><strong>{{ number_format($used,2) }}GB</strong></div>
        </div>
    </section>
@endif
@endsection
