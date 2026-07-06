import { TicketCardPortal } from '@/features/customer-portal/components';
import { ticketCards } from '@/features/customer-portal/data';
import { AppCard, DataTable, PageHeader, SectionHeader } from '@/shared/ui/components';

export default function CustomerTicketsPage() {
  return <div className="space-y-6"><PageHeader title="My Tickets" description="QR ticket, download PDF, boarding status, check-in status, and trip detail using existing TicketService." />
    <div className="grid gap-4 lg:grid-cols-2">{ticketCards.map((card) => <TicketCardPortal key={card.id} card={card} />)}</div>
    <AppCard><SectionHeader title="Ticket Status" /><div className="mt-4"><DataTable columns={['Ticket', 'QR', 'Check In', 'Boarding']} rows={ticketCards.map((card) => [card.id, 'Ready', card.status === 'completed' ? 'Checked in' : 'Pending', card.status])} /></div></AppCard>
  </div>;
}
