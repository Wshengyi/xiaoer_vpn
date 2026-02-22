# 小二Cloud Laravel MVP

## 技术栈
- Laravel 12
- PHP 8.5+
- MySQL 8+

## 功能（MVP v0.3）
- 首页套餐展示（默认：月付15）
- 用户登录 / 用户注册
- 用户中心（状态、下次扣费、流量）
- 订阅链接中心（Clash / Shadowrocket）
- 简易管理后台（新增套餐、创建订阅、重置订阅 Token）
- 购买流程（确认下单 → 订单详情 → 模拟支付成功）
- 订单记录（后台可查看最近订单）

## 初始化
1. 创建数据库：`xiaoercloud`
2. 配置 `.env` 里的 MySQL 账号密码
3. 执行：

```bash
cd xiaoercloud-laravel
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

访问：`http://127.0.0.1:8000`

## 演示账号（管理员）
- demo@xiaoercloud.local
- 123456

登录后可在用户中心进入“管理后台”（/admin）。
