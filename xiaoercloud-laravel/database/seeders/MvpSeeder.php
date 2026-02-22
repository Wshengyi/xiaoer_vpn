<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MvpSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->updateOrCreate(
            ['email' => 'demo@xiaoercloud.local'],
            ['name' => 'Demo用户', 'password' => Hash::make('123456'), 'is_admin' => true]
        );

        $plan = Plan::query()->updateOrCreate(
            ['name' => '月付15'],
            ['price' => 15, 'cycle' => '月', 'traffic_gb' => 250, 'active' => true]
        );

        Subscription::query()->updateOrCreate(
            ['user_id' => $user->id, 'plan_id' => $plan->id],
            [
                'status' => '有效',
                'next_billing_date' => now()->addMonth()->toDateString(),
                'used_upload_gb' => 0,
                'used_download_gb' => 0,
                'clash_url' => 'https://example.local/sub/clash/demo-token',
                'shadowrocket_url' => 'https://example.local/sub/shadowrocket/demo-token',
            ]
        );
    }
}
