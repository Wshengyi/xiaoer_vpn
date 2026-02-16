import Hero from '../components/Hero';

async function getHealth() {
  try {
    const base = process.env.NEXT_PUBLIC_API_BASE_URL || 'http://localhost:8000';
    const res = await fetch(`${base}/health`, { cache: 'no-store' });
    if (!res.ok) return 'offline';
    const data = await res.json();
    return data.status || 'ok';
  } catch {
    return 'offline';
  }
}

export default async function HomePage() {
  const health = await getHealth();

  return (
    <main>
      <header className="border-b border-slate-800">
        <div className="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
          <div className="font-bold">xiaoer_vpn</div>
          <div className="text-sm text-slate-400">API: {health}</div>
        </div>
      </header>
      <Hero />
      <section id="plans" className="mx-auto max-w-6xl px-6 pb-20">
        <h2 className="text-2xl font-semibold">套餐与服务</h2>
        <div className="mt-6 grid gap-4 md:grid-cols-3">
          {['基础版', '专业版', '企业版'].map((n) => (
            <article key={n} className="rounded-2xl border border-slate-800 p-6">
              <h3 className="text-xl font-semibold">{n}</h3>
              <p className="mt-2 text-slate-400">高速节点、稳定连接、7x24 支持。</p>
            </article>
          ))}
        </div>
      </section>
      <footer id="contact" className="border-t border-slate-800 py-10 text-center text-slate-400">
        联系邮箱：support@firstdemo.cn
      </footer>
    </main>
  );
}
