import { Car, Bell, Route } from 'lucide-react';
import { ConnectionIndicator, OfflineBanner } from '@/shared/components';

export default function AdminOperationsPage() {
  return <main className="min-h-screen bg-secondary p-6 text-slate-950"><OfflineBanner/><section className="mx-auto max-w-7xl"><ConnectionIndicator/><h1 className="mt-6 font-display text-4xl font-bold">Live Operations</h1><div className="mt-8 grid gap-6 lg:grid-cols-3"><div className="rounded-[2rem] bg-white p-6 shadow-soft"><Car className="text-primary"/><h2 className="mt-4 font-bold">Fleet Map</h2><p className="text-sm text-slate-500">Realtime fleet positions.</p></div><div className="rounded-[2rem] bg-white p-6 shadow-soft"><Route className="text-primary"/><h2 className="mt-4 font-bold">Drivers & Trips</h2><p className="text-sm text-slate-500">Live trip status updates.</p></div><div className="rounded-[2rem] bg-white p-6 shadow-soft"><Bell className="text-primary"/><h2 className="mt-4 font-bold">Notifications</h2><p className="text-sm text-slate-500">Realtime operational alerts.</p></div></div></section></main>;
}
