<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    private function ensureAdmin()
    {
        abort_unless(Auth::user()?->is_admin, 403, '仅管理员可访问');
    }

    public function index()
    {
        $this->ensureAdmin();

        $plans = Plan::query()->latest('id')->get();
        $users = User::query()->latest('id')->get();
        $subscriptions = Subscription::query()->with(['user', 'plan'])->latest('id')->get();
        $orders = Order::query()->with(['user', 'plan'])->latest('id')->limit(20)->get();

        return view('admin.index', compact('plans', 'users', 'subscriptions', 'orders'));
    }

    public function storePlan(Request $request)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'cycle' => 'required|string|max:20',
            'traffic_gb' => 'required|integer|min:1',
        ]);

        Plan::query()->create($data + ['active' => true]);
        return back();
    }

    public function updatePlan(Request $request, Plan $plan)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'cycle' => 'required|string|max:20',
            'traffic_gb' => 'required|integer|min:1',
            'active' => 'nullable|boolean',
        ]);

        $plan->update($data + ['active' => (bool)($data['active'] ?? false)]);
        return back();
    }

    public function deletePlan(Plan $plan)
    {
        $this->ensureAdmin();
        $plan->delete();
        return back();
    }

    public function storeSubscription(Request $request)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'plan_id' => 'required|exists:plans,id',
            'status' => 'required|string|max:20',
            'next_billing_date' => 'nullable|date',
            'clash_url' => 'nullable|string',
            'shadowrocket_url' => 'nullable|string',
        ]);

        Subscription::query()->create($data + [
            'used_upload_gb' => 0,
            'used_download_gb' => 0,
        ]);

        return back();
    }

    public function updateSubscription(Request $request, Subscription $subscription)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'status' => 'required|string|max:20',
            'next_billing_date' => 'nullable|date',
        ]);

        $subscription->update($data);
        return back();
    }

    public function deleteSubscription(Subscription $subscription)
    {
        $this->ensureAdmin();
        $subscription->delete();
        return back();
    }

    public function resetToken(Subscription $subscription)
    {
        $this->ensureAdmin();

        $token = bin2hex(random_bytes(8));
        $subscription->update([
            'clash_url' => "https://example.local/sub/clash/{$token}",
            'shadowrocket_url' => "https://example.local/sub/shadowrocket/{$token}",
        ]);

        return back();
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'status' => 'required|in:待支付,已支付,已取消',
        ]);

        $order->update([
            'status' => $data['status'],
            'paid_at' => $data['status'] === '已支付' ? now() : null,
        ]);

        if ($data['status'] === '已支付') {
            $exists = Subscription::query()
                ->where('user_id', $order->user_id)
                ->where('plan_id', $order->plan_id)
                ->whereDate('created_at', now()->toDateString())
                ->exists();

            if (!$exists) {
                $token = strtolower(Str::random(16));
                Subscription::query()->create([
                    'user_id' => $order->user_id,
                    'plan_id' => $order->plan_id,
                    'status' => '有效',
                    'next_billing_date' => now()->addMonth()->toDateString(),
                    'used_upload_gb' => 0,
                    'used_download_gb' => 0,
                    'clash_url' => "https://example.local/sub/clash/{$token}",
                    'shadowrocket_url' => "https://example.local/sub/shadowrocket/{$token}",
                ]);
            }
        }

        return back();
    }
}

