<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
