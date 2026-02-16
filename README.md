# xiaoer_vpn (小二VPN)

前后端分离官网项目（从 0 到 1 重构版）。

## 技术栈

- Frontend: Next.js 15 + React 19 + TypeScript + TailwindCSS
- Backend: FastAPI + SQLAlchemy + Pydantic v2
- DB: PostgreSQL 16
- Deploy: Docker Compose + Nginx（域名 `vpn.firstdemo.cn`）

## 目录结构

- `frontend/` 前端应用
- `backend/` 后端 API
- `infra/nginx/` 反向代理配置
- `docs/` 设计和接口文档

## 本地启动（Docker）

```bash
docker compose up -d --build
```

访问：
- 前端: http://localhost:3000
- 后端: http://localhost:8000/docs

## 生产部署建议（宝塔）

- 宝塔站点域名：`vpn.firstdemo.cn`
- Nginx 反向代理到前端容器（3000）
- `/api` 反代到后端容器（8000）
- SSL 证书用宝塔自动申请
