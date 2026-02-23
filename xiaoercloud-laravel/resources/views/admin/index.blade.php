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
        <h3>套餐管理</h3>
        @foreach($plans as $p)
            <form class="card" style="margin-bottom:8px" method="POST" action="{{ route('admin.plans.update', $p) }}">
                @csrf @method('PUT')
                <div class="grid" style="grid-template-columns:2fr 1fr 1fr 1fr 1fr;gap:8px;align-items:center;">
                    <input class="input" name="name" value="{{ $p->name }}">
                    <input class="input" name="price" type="number" step="0.01" value="{{ $p->price }}">
                    <input class="input" name="cycle" value="{{ $p->cycle }}">
                    <input class="input" name="traffic_gb" type="number" value="{{ $p->traffic_gb }}">
                    <label class="label"><input type="checkbox" name="active" value="1" {{ $p->active ? 'checked' : '' }}> 启用</label>
                </div>
                <div class="actions" style="margin-top:8px">
                    <button class="btn ghost" type="submit">保存</button>
                </div>
            </form>
            <form method="POST" action="{{ route('admin.plans.delete', $p) }}" onsubmit="return confirm('确定删除该套餐？');">
                @csrf @method('DELETE')
                <button class="btn ghost" type="submit">删除套餐 #{{ $p->id }}</button>
            </form>
        @endforeach
    </div>

    <div class="card panel">
        <h3>订阅管理（状态/续费日/重置Token/删除）</h3>
        @foreach($subscriptions as $s)
            <div class="card" style="margin-bottom:8px">
                <div class="kv"><span>#{{ $s->id }} {{ $s->user->email }}</span><strong>{{ $s->plan->name }}</strong></div>
                <form method="POST" action="{{ route('admin.subscriptions.update', $s) }}" class="actions" style="margin-top:8px">
                    @csrf @method('PUT')
                    <select class="input" style="max-width:160px" name="status">
                        @foreach(['有效','已暂停','已终止','已取消'] as $st)
                            <option value="{{ $st }}" {{ $s->status === $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                    <input class="input" style="max-width:220px" type="date" name="next_billing_date" value="{{ optional($s->next_billing_date)->toDateString() }}">
                    <button class="btn ghost" type="submit">保存</button>
                </form>
                <div class="actions" style="margin-top:8px">
                    <form method="POST" action="{{ route('admin.subscriptions.resetToken', $s) }}">@csrf<button class="btn ghost" type="submit">重置订阅Token</button></form>
                    <form method="POST" action="{{ route('admin.subscriptions.delete', $s) }}" onsubmit="return confirm('确定删除该订阅？');">@csrf @method('DELETE')<button class="btn ghost" type="submit">删除订阅</button></form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card panel">
        <h3>订单管理（最近20条）</h3>
        @forelse($orders as $o)
            <div class="card" style="margin-bottom:8px">
                <div class="kv"><span>{{ $o->order_no }} · {{ $o->user->email }} · {{ $o->plan->name }}</span><strong>¥{{ number_format($o->amount,2) }}</strong></div>
                <form method="POST" action="{{ route('admin.orders.updateStatus', $o) }}" class="actions" style="margin-top:8px">
                    @csrf @method('PUT')
                    <select class="input" style="max-width:180px" name="status">
                        @foreach(['待支付','已支付','已取消'] as $st)
                            <option value="{{ $st }}" {{ $o->status === $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                    <button class="btn ghost" type="submit">更新状态</button>
                </form>
            </div>
        @empty
            <p class="notice">暂无订单</p>
        @endforelse
    </div>
</section>
@endsection
