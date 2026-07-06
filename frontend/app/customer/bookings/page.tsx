import { BookingCard, ConfirmationDialogPreview, CustomerTimeline } from '@/features/customer-portal/components';
import { bookingCards, timelineItems } from '@/features/customer-portal/data';
import { PageHeader, SectionHeader, AppCard, DataTable } from '@/shared/ui/components';

export default function CustomerBookingsPage() {
  return <div className="space-y-6"><PageHeader title="My Bookings" description="Active booking, detail, passenger, seat, invoice, cancel flow, timeline, and booking history." />
    <div className="grid gap-4 lg:grid-cols-3">{bookingCards.map((card) => <BookingCard key={card.id} card={card} />)}</div>
    <div className="grid gap-4 xl:grid-cols-2"><CustomerTimeline items={timelineItems} /><ConfirmationDialogPreview /></div>
    <AppCard><SectionHeader title="Booking History" description="Read from existing customer booking endpoint." /><div className="mt-4"><DataTable columns={['Booking', 'Route', 'Status', 'Invoice']} rows={bookingCards.map((card) => [card.id, card.title, card.status, 'Available'])} /></div></AppCard>
  </div>;
}
