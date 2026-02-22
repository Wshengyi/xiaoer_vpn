<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function home()
    {
        $plans = Plan::query()->where('active', true)->get();
        return view('home', compact('plans'));
    }

    public function dashboard()
    {
        $subscription = Subscription::query()
            ->with('plan')
            ->where('user_id', Auth::id())
            ->latest('id')
            ->first();

        return view('dashboard', compact('subscription'));
    }

    public function subscriptionLinks()
    {
        $subscription = Subscription::query()
            ->with('plan')
            ->where('user_id', Auth::id())
            ->latest('id')
            ->first();

        return view('subscription', compact('subscription'));
    }
}
