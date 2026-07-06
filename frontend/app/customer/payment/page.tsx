import { PaymentCard } from '@/features/customer-portal/components';
import { paymentCards } from '@/features/customer-portal/data';
import { AppCard, DataTable, PageHeader, SectionHeader } from '@/shared/ui/components';

export default function CustomerPaymentPage() {
  return <div className="space-y-6"><PageHeader title="Payments" description="Waiting, success, failed, expired, retry, countdown, history, and polling status through existing PaymentService and Midtrans integration." />
    <div className="grid gap-4 lg:grid-cols-3">{paymentCards.map((card) => <PaymentCard key={card.id} card={card} />)}</div>
    <AppCard><SectionHeader title="Countdown & Polling" description="UI polls GET /v1/payments/{payment}; webhook remains handled by existing backend." /><p className="mt-4 font-display text-4xl font-bold text-amber-600">23:59</p></AppCard>
    <AppCard><SectionHeader title="Payment History" /><div className="mt-4"><DataTable columns={['Payment', 'Method', 'Status', 'Action']} rows={paymentCards.map((card) => [card.id, 'Midtrans', card.status, card.status === 'waiting' ? 'Retry Payment' : 'View'])} /></div></AppCard>
  </div>;
}
