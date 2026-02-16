import './globals.css';
import type { Metadata } from 'next';

export const metadata: Metadata = {
  title: '小二VPN - 安全稳定的网络服务',
  description: '小二VPN官网，提供稳定、快速、可维护的网络服务。',
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="zh-CN">
      <body>{children}</body>
    </html>
  );
}
