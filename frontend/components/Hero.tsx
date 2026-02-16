export default function Hero() {
  return (
    <section className="mx-auto max-w-6xl px-6 py-20">
      <h1 className="text-4xl md:text-6xl font-bold leading-tight">
        小二VPN
        <span className="block text-cyan-400">更快 · 更稳 · 更安全</span>
      </h1>
      <p className="mt-6 max-w-2xl text-slate-300">
        基于现代化架构构建，支持多终端接入、可视化维护与弹性扩容。
      </p>
      <div className="mt-8 flex gap-4">
        <a className="rounded-xl bg-cyan-500 px-5 py-3 font-semibold text-slate-950" href="#plans">查看套餐</a>
        <a className="rounded-xl border border-slate-700 px-5 py-3" href="#contact">联系支持</a>
      </div>
    </section>
  );
}
