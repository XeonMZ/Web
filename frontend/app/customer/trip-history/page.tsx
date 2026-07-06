import { AppCard, DataTable, PageHeader, SectionHeader } from '@/shared/ui/components';

export default function TripHistoryPage() {
  return <div className="space-y-6"><PageHeader title="Trip History" description="Completed trip, cancelled trip, rating, review, receipt, and invoice." /><AppCard><SectionHeader title="History" /><div className="mt-4"><DataTable columns={['Trip', 'Status', 'Rating', 'Document']} rows={[[ 'Surabaya → Malang', 'Completed', '5/5 Review sent', 'Receipt & invoice' ], [ 'Jakarta → Bogor', 'Cancelled', '-', 'Refund receipt' ]]} /></div></AppCard></div>;
}
