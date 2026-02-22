<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function checkout(Plan $plan)
    {
        return view('orders.checkout', compact('plan'));
    }

    public function store(Request $request, Plan $plan)
    {
        $user = Auth::user();

        $order = Order::query()->create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'order_no' => 'XO' . now()->format('YmdHis') . strtoupper(Str::random(4)),
            'amount' => $plan->price,
            'status' => '待支付',
        ]);

        return redirect()->route('orders.show', $order);
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === Auth::id() || Auth::user()?->is_admin, 403);
        $order->load('plan');
        return view('orders.show', compact('order'));
    }

    public function pay(Order $order)
    {
        abort_unless($order->user_id === Auth::id() || Auth::user()?->is_admin, 403);

        if ($order->status !== '已支付') {
            $order->update([
                'status' => '已支付',
                'paid_at' => now(),
            ]);

            Subscription::query()->create([
                'user_id' => $order->user_id,
                'plan_id' => $order->plan_id,
                'status' => '有效',
                'next_billing_date' => now()->addMonth()->toDateString(),
                'used_upload_gb' => 0,
                'used_download_gb' => 0,
                'clash_url' => 'https://example.local/sub/clash/' . strtolower(Str::random(16)),
                'shadowrocket_url' => 'https://example.local/sub/shadowrocket/' . strtolower(Str::random(16)),
            ]);
        }

        return redirect()->route('dashboard');
    }
}
