import express from 'express';
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const app = express();
const PORT = 3000;
const DB_PATH = path.join(__dirname, 'data', 'db.json');

app.use(express.json());
app.use(express.static(path.join(__dirname, 'public')));

function readDb() {
  return JSON.parse(fs.readFileSync(DB_PATH, 'utf-8'));
}

function auth(req, res, next) {
  const uid = Number(req.headers['x-user-id'] || 0);
  if (!uid) return res.status(401).json({ error: '未登录' });
  req.userId = uid;
  next();
}

app.post('/api/login', (req, res) => {
  const { email, password } = req.body || {};
  const db = readDb();
  const user = db.users.find((u) => u.email === email && u.password === password);
  if (!user) return res.status(401).json({ error: '账号或密码错误' });
  res.json({ id: user.id, name: user.name, email: user.email });
});

app.get('/api/plans', (req, res) => {
  const db = readDb();
  res.json(db.plans);
});

app.get('/api/me/subscription', auth, (req, res) => {
  const db = readDb();
  const sub = db.subscriptions.find((s) => s.userId === req.userId);
  if (!sub) return res.status(404).json({ error: '无订阅' });
  const plan = db.plans.find((p) => p.id === sub.planId);
  const total = plan?.trafficGb || 0;
  const used = (sub.usedUploadGb || 0) + (sub.usedDownloadGb || 0);
  const remaining = Math.max(0, total - used);
  res.json({ ...sub, plan, total, used, remaining });
});

app.listen(PORT, () => {
  console.log(`小二Clould MVP running: http://localhost:${PORT}`);
});
