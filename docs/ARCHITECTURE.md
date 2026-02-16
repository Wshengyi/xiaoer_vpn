# 架构说明

## 目标
- 前后端分离
- 宝塔可维护
- 支持后续会员/支付/节点管理扩展

## 当前版本（MVP）
- 前端：Next.js SSR
- 后端：FastAPI REST API
- 数据库：PostgreSQL
- 反向代理：Nginx

## 后续路线
1. 用户认证（JWT + 刷新令牌）
2. 管理后台（文章、套餐、节点）
3. 订单与支付
4. 观测（Sentry + Prometheus）
