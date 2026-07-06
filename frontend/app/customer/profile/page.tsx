import { AppCard, DataTable, PageHeader, SectionHeader } from '@/shared/ui/components';

export default function ProfilePage() {
  const rows = [['Avatar', 'Upload / replace'], ['Email', 'Verify and update'], ['Phone', 'OTP-ready field'], ['Password', 'Change password endpoint'], ['Emergency Contact', 'Name and phone'], ['Address', 'Customer address book'], ['Device Session', 'Active Sanctum sessions'], ['Notification Preference', 'Channel preferences']];
  return <div className="space-y-6"><PageHeader title="Profile" description="Customer profile settings through existing auth profile endpoints." /><AppCard><SectionHeader title="Edit Profile" /><div className="mt-4"><DataTable columns={['Section', 'Capability']} rows={rows} /></div></AppCard></div>;
}
