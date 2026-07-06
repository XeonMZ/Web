import { AppCard, DataTable, PageHeader, StatsCard } from '@/shared/ui/components';

export default function Page() {
  return (
    <div className="space-y-6">
      <PageHeader title="Customer Dashboard" description="Customer self-service workspace using the shared STMS UI foundation." />
      <div className="grid gap-4 md:grid-cols-3">
        <StatsCard label="Active" value="--" helper="Connected to existing flows" />
        <StatsCard label="Pending" value="--" helper="Ready for Sprint integration" />
        <StatsCard label="Alerts" value="--" helper="Realtime UI enabled" />
      </div>
      <AppCard>
        <DataTable columns={['Area', 'Status']} rows={[['Shared layout', 'Active'], ['Role navigation', 'Configured'], ['Business logic', 'Unchanged']]} />
      </AppCard>
    </div>
  );
}
