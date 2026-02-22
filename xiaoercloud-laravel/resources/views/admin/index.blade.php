@extends('layouts.app', ['title' => '管理后台 - 小二Cloud'])

@section('content')
<div class="topbar"><div class="logo">管理后台</div></div>

<section class="grid">
    <div class="card plan">
        <h3>新增套餐</h3>
        <form method="POST" action="{{ route('admin.plans.store') }}">
            @csrf
            <input class="input" name="name" placeholder="套餐名（如 月付15）" required>
            <input class="input" name="price" type="number" step="0.01" placeholder="价格" required>
            <input class="input" name="cycle" placeholder="周期（月/季/年）" value="月" required>
            <input class="input" name="traffic_gb" type="number" placeholder="流量GB" value="250" required>
            <button class="btn" type="submit">创建套餐</button>
        </form>
    </div>

    <div class="card plan">
        <h3>新增订阅</h3>
        <form method="POST" action="{{ route('admin.subscriptions.store') }}">
            @csrf
            <label class="label">用户</label>
            <select class="input" name="user_id">
                @foreach($users as $u)<option value="{{ $u->id }}">{{ $u->id }} - {{ $u->email }}</option>@endforeach
            </select>
            <label class="label">套餐</label>
            <select class="input" name="plan_id">
                @foreach($plans as $p)<option value="{{ $p->id }}">{{ $p->id }} - {{ $p->name }}</option>@endforeach
            </select>
            <input class="input" name="status" value="有效" required>
            <input class="input" name="next_billing_date" type="date">
            <input class="input" name="clash_url" placeholder="Clash URL">
            <input class="input" name="shadowrocket_url" placeholder="Shadowrocket URL">
            <button class="btn" type="submit">创建订阅</button>
        </form>
    </div>

    <div class="card panel">
        <h3>订阅列表（可重置 Token）</h3>
        @foreach($subscriptions as $s)
            <div class="card" style="margin-bottom:8px">
                <div class="kv"><span>#{{ $s->id }} {{ $s->user->email }}</span><strong>{{ $s->plan->name }} / {{ $s->status }}</strong></div>
                <form method="POST" action="{{ route('admin.subscriptions.resetToken', $s) }}" style="margin-top:8px">
                    @csrf
                    <button class="btn ghost" type="submit">重置订阅Token</button>
                </form>
            </div>
        @endforeach
    </div>

    <div class="card panel">
        <h3>最近订单（v0.3）</h3>
        @forelse($orders as $o)
            <div class="kv">
                <span>{{ $o->order_no }} · {{ $o->user->email }} · {{ $o->plan->name }}</span>
                <strong>¥{{ number_format($o->amount,2) }} / {{ $o->status }}</strong>
            </div>
        @empty
            <p class="notice">暂无订单</p>
        @endforelse
    </div>
</section>
@endsection
