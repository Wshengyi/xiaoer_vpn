<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Db;

class Cloud extends Frontend
{
    protected $noNeedLogin = ['index'];
    protected $noNeedRight = ['*'];
    protected $layout = '';

    public function index()
    {
        $plans = Db::name('plan')->where('status', 'normal')->order('id asc')->select();
        if (!$plans) {
            Db::name('plan')->insert([
                'name' => '月付15',
                'price' => 15,
                'cycle' => '月',
                'traffic_gb' => 250,
                'status' => 'normal',
                'createtime' => time(),
                'updatetime' => time(),
            ]);
            $plans = Db::name('plan')->where('status', 'normal')->order('id asc')->select();
        }
        $this->view->assign('plans', $plans);
        return $this->view->fetch();
    }

    public function dashboard()
    {
        $this->auth->check() || $this->error('请先登录', url('user/login'));

        $sub = Db::name('subscription')
            ->alias('s')
            ->join('plan p', 'p.id=s.plan_id', 'LEFT')
            ->where('s.user_id', $this->auth->id)
            ->order('s.id desc')
            ->field('s.*,p.name as plan_name,p.price,p.cycle,p.traffic_gb')
            ->find();

        $remaining = 0;
        if ($sub) {
            $used = (float)$sub['used_upload_gb'] + (float)$sub['used_download_gb'];
            $remaining = max(0, (float)$sub['traffic_gb'] - $used);
            $sub['used'] = $used;
            $sub['remaining'] = $remaining;
        }

        $this->view->assign('sub', $sub);
        return $this->view->fetch();
    }

    public function subscription()
    {
        $this->auth->check() || $this->error('请先登录', url('user/login'));

        $sub = Db::name('subscription')
            ->alias('s')
            ->join('plan p', 'p.id=s.plan_id', 'LEFT')
            ->where('s.user_id', $this->auth->id)
            ->order('s.id desc')
            ->field('s.*,p.name as plan_name,p.price,p.cycle,p.traffic_gb')
            ->find();

        $this->view->assign('sub', $sub);
        return $this->view->fetch();
    }

    public function checkout($id = null)
    {
        $this->auth->check() || $this->error('请先登录', url('user/login'));
        $plan = Db::name('plan')->where('id', intval($id))->find();
        if (!$plan) {
            $this->error('套餐不存在');
        }

        if ($this->request->isPost()) {
            $orderNo = 'XO' . date('YmdHis') . strtoupper(substr(md5(uniqid('', true)), 0, 4));
            $orderId = Db::name('order')->insertGetId([
                'order_no' => $orderNo,
                'user_id' => $this->auth->id,
                'plan_id' => $plan['id'],
                'amount' => $plan['price'],
                'pay_status' => '待支付',
                'createtime' => time(),
                'updatetime' => time(),
            ]);
            $this->redirect(url('index/cloud/order', ['id' => $orderId]));
        }

        $this->view->assign('plan', $plan);
        return $this->view->fetch();
    }

    public function order($id = null)
    {
        $this->auth->check() || $this->error('请先登录', url('user/login'));
        $order = Db::name('order')
            ->alias('o')
            ->join('plan p', 'p.id=o.plan_id', 'LEFT')
            ->where('o.id', intval($id))
            ->where('o.user_id', $this->auth->id)
            ->field('o.*,p.name as plan_name,p.cycle')
            ->find();
        if (!$order) {
            $this->error('订单不存在');
        }
        $this->view->assign('order', $order);
        return $this->view->fetch();
    }

    public function pay($id = null)
    {
        $this->auth->check() || $this->error('请先登录', url('user/login'));
        $order = Db::name('order')->where('id', intval($id))->where('user_id', $this->auth->id)->find();
        if (!$order) {
            $this->error('订单不存在');
        }
        if ($order['pay_status'] !== '已支付') {
            Db::name('order')->where('id', $order['id'])->update([
                'pay_status' => '已支付',
                'paid_at' => date('Y-m-d H:i:s'),
                'updatetime' => time(),
            ]);

            \app\common\service\OrderFulfillment::fulfill((int)$order['id']);
        }

        $this->redirect(url('index/cloud/dashboard'));
    }
}
