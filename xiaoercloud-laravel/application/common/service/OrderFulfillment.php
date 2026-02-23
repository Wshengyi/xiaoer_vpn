<?php

namespace app\common\service;

use think\Db;

class OrderFulfillment
{
    /**
     * 订单支付后的交付逻辑（幂等）
     */
    public static function fulfill(int $orderId): bool
    {
        $order = Db::name('order')->where('id', $orderId)->find();
        if (!$order || $order['pay_status'] !== '已支付') {
            return false;
        }

        // 幂等：同一订单只交付一次
        $exists = Db::name('subscription')->where('source_order_id', $order['id'])->find();
        if ($exists) {
            return true;
        }

        $plan = Db::name('plan')->where('id', $order['plan_id'])->find();
        if (!$plan) {
            return false;
        }

        $active = Db::name('subscription')
            ->where('user_id', $order['user_id'])
            ->where('plan_id', $order['plan_id'])
            ->where('sub_status', '有效')
            ->order('id desc')
            ->find();

        if ($active) {
            $base = !empty($active['next_billing_date']) && strtotime($active['next_billing_date']) > time()
                ? strtotime($active['next_billing_date'])
                : time();

            Db::name('subscription')->where('id', $active['id'])->update([
                'next_billing_date' => date('Y-m-d', strtotime('+30 day', $base)),
                'updatetime' => time(),
                'source_order_id' => $order['id'],
            ]);
            return true;
        }

        $token = strtolower(substr(md5(uniqid('', true)), 0, 16));
        Db::name('subscription')->insert([
            'user_id' => $order['user_id'],
            'plan_id' => $order['plan_id'],
            'sub_status' => '有效',
            'next_billing_date' => date('Y-m-d', strtotime('+30 day')),
            'used_upload_gb' => 0,
            'used_download_gb' => 0,
            'clash_url' => 'https://example.local/sub/clash/' . $token,
            'shadowrocket_url' => 'https://example.local/sub/shadowrocket/' . $token,
            'source_order_id' => $order['id'],
            'createtime' => time(),
            'updatetime' => time(),
        ]);

        return true;
    }
}
