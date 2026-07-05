import { ConnectionIndicator, OfflineBanner } from '@/shared/components';
import { Button } from '@/components/button';

const actions = ['Start Trip', 'Pause Trip', 'Resume Trip', 'Finish Trip', 'Share GPS', 'Stop GPS'];
export default function DriverDashboardPage() {
  return <main className="min-h-screen bg-secondary p-6 text-slate-950"><OfflineBanner/><section className="mx-auto max-w-5xl"><ConnectionIndicator/><h1 className="mt-6 font-display text-4xl font-bold">Driver Dashboard</h1><div className="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">{actions.map((action) => <Button key={action} className="w-full">{action}</Button>)}</div></section></main>;
}
