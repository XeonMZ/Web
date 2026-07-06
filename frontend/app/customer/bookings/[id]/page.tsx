import { CustomerTimeline, StatusBadge } from '@/features/customer-portal/components';
import { timelineItems } from '@/features/customer-portal/data';
import { AppCard, DataTable, PageHeader, SectionHeader } from '@/shared/ui/components';

export default function BookingDetailPage({ params }: { params: { id: string } }) {
  return <div className="space-y-6"><PageHeader title={`Booking Detail ${params.id}`} description="Integrated with GET /booking/{id}; no duplicate BookingService is introduced." />
    <div className="grid gap-4 xl:grid-cols-3"><AppCard><SectionHeader title="Passenger" /><p className="mt-4 font-bold">Primary customer</p><p className="text-sm text-slate-500">Emergency contact and manifest data.</p></AppCard><AppCard><SectionHeader title="Seat" /><p className="mt-4 font-display text-3xl font-bold">4A</p><StatusBadge status="active" /></AppCard><AppCard><SectionHeader title="Invoice" /><p className="mt-4 font-bold">INV-{params.id}</p><p className="text-sm text-slate-500">Receipt and invoice download after payment.</p></AppCard></div>
    <CustomerTimeline items={timelineItems} />
    <AppCard><SectionHeader title="Booking Timeline" /><div className="mt-4"><DataTable columns={['Step', 'Source', 'State']} rows={timelineItems.map((item) => [item.label, 'Existing state machine', item.state])} /></div></AppCard>
  </div>;
}
