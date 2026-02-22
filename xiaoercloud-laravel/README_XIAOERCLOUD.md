# 小二Cloud Laravel MVP

## 技术栈
- Laravel 12
- PHP 8.5+
- MySQL 8+

## 功能（MVP）
- 首页套餐展示（默认：月付15）
- 用户登录
- 用户中心（状态、下次扣费、流量）
- 订阅链接中心（Clash / Shadowrocket）

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

## 演示账号
- demo@xiaoercloud.local
- 123456
