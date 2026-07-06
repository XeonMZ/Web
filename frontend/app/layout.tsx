import type { Metadata, Viewport } from 'next';
import { Inter, Poppins } from 'next/font/google';
import { AppProviders } from '@/lib/query-client';
import { AppShell } from '@/shared/ui/layout/app-shell';
import '@/styles/globals.css';

const inter = Inter({ subsets: ['latin'], variable: '--font-inter' });
const poppins = Poppins({ subsets: ['latin'], weight: ['500', '600', '700', '800'], variable: '--font-poppins' });

export const metadata: Metadata = {
  title: 'SJT Travel Management System',
  description: 'Premium booking, fleet, driver, and travel operations platform for SJT.',
  applicationName: 'STMS',
  manifest: '/manifest.json',
  keywords: ['travel management', 'booking', 'fleet', 'SJT'],
};

export const viewport: Viewport = {
  themeColor: '#2563EB',
  width: 'device-width',
  initialScale: 1,
};

export default function RootLayout({ children }: Readonly<{ children: React.ReactNode }>) {
  return (
    <html lang="en">
      <body className={`${inter.variable} ${poppins.variable} font-sans antialiased`}>
        <AppProviders><AppShell>{children}</AppShell></AppProviders>
      </body>
    </html>
  );
}
