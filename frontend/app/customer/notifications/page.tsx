import { notifications } from '@/features/customer-portal/data';
import { AppCard, DataTable, FilterBar, PageHeader, SearchBar, SectionHeader } from '@/shared/ui/components';

export default function NotificationsPage() {
  return <div className="space-y-6"><PageHeader title="Notification Center" description="Read, unread, mark read, mark all read, search, filter, infinite scroll, and realtime through existing notification/realtime foundation." /><FilterBar><SearchBar placeholder="Search notifications" className="min-w-72 flex-1" /><span className="rounded-full bg-primary px-3 py-1 text-xs font-bold text-white">Unread</span><span className="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold dark:bg-slate-800">Read</span><span className="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold dark:bg-slate-800">Mark all read</span></FilterBar><AppCard><SectionHeader title="Realtime Preview" /><div className="mt-4"><DataTable columns={['Notification', 'State', 'Action']} rows={notifications.map((item, index) => [item, index === 0 ? 'Unread' : 'Read', 'Mark Read'])} /></div></AppCard></div>;
}
