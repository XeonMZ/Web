import { QrCode } from 'lucide-react';
import { StatusBadge } from '@/features/customer-portal/components';
import { AppCard, PageHeader, SectionHeader } from '@/shared/ui/components';

export default function TicketDetailPage({ params }: { params: { id: string } }) {
  return <div className="space-y-6"><PageHeader title={`Ticket Detail ${params.id}`} description="TicketService provides QR, PDF, trip detail, check-in, and boarding state." />
    <div className="grid gap-4 xl:grid-cols-3"><AppCard className="xl:col-span-2"><SectionHeader title="QR Ticket" /><div className="mt-6 grid h-72 place-items-center rounded-3xl border border-dashed border-slate-300 dark:border-slate-700"><QrCode size={112} className="text-primary" /></div></AppCard><AppCard><SectionHeader title="Boarding Status" /><div className="mt-4 space-y-3"><StatusBadge status="active" /><p className="text-sm text-slate-500">Download PDF, check-in status, and trip detail actions are presented here.</p></div></AppCard></div>
  </div>;
}
