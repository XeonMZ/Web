import { AppCard, PageHeader, SectionHeader } from '@/shared/ui/components';
import { BookingCard, CustomerTimeline, MembershipCardPortal, PaymentCard, PortalFeatureGrid, PromoCard, QuickActions, StatisticCard, TicketCardPortal } from '@/features/customer-portal/components';
import { bookingCards, dashboardMetrics, paymentCards, promoCards, ticketCards, timelineItems } from '@/features/customer-portal/data';

export default function Page() {
  return <div className="space-y-6"><PageHeader title="Customer Dashboard" description="Portal pelanggan responsive, PWA ready, dark mode, dan hanya mengintegrasikan engine backend yang sudah ada." />
    <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-4">{dashboardMetrics.map((metric) => <StatisticCard key={metric.label} metric={metric} />)}</div>
    <QuickActions />
    <div className="grid gap-4 xl:grid-cols-3"><BookingCard card={bookingCards[0]} /><PaymentCard card={paymentCards[0]} /><TicketCardPortal card={ticketCards[0]} /></div>
    <div className="grid gap-4 xl:grid-cols-2"><MembershipCardPortal card={{ id: 'MBR', title: 'Gold Membership', description: 'Level, points, benefits, point history, and upgrade progress.', status: 'active', meta: '78% to Platinum', href: '/customer/membership' }} /><PromoCard card={promoCards[0]} /></div>
    <AppCard><SectionHeader title="Booking Progress" description="Progress follows existing booking, payment, ticket, check-in, and boarding state machines." /><div className="mt-4"><CustomerTimeline items={timelineItems} /></div></AppCard>
    <PortalFeatureGrid />
  </div>;
}
