import { BarChart3, BookOpen, Bus, CalendarClock, DatabaseBackup, Flag, LayoutDashboard, ListChecks, Map, Receipt, Route, Settings, ShieldCheck, Users, Wrench } from 'lucide-react';
import type { MenuItem } from './types';

export const ownerMenu: MenuItem[] = [
  { label: 'Dashboard', href: '/owner', icon: LayoutDashboard },
  { label: 'Booking', href: '/booking', icon: BookOpen },
  { label: 'Trips', href: '/owner/trips', icon: Route },
  { label: 'Routes', href: '/owner/routes', icon: Map },
  { label: 'Schedules', href: '/owner/schedules', icon: CalendarClock },
  { label: 'Vehicles', href: '/owner/fleet', icon: Bus },
  { label: 'Drivers', href: '/owner/drivers', icon: Users },
  { label: 'Payments', href: '/payment', icon: Receipt },
  { label: 'Reports', href: '/owner/reports', icon: BarChart3 },
  { label: 'Monitoring', href: '/owner/monitoring', icon: ShieldCheck },
  { label: 'Backup', href: '/owner/backup', icon: DatabaseBackup },
  { label: 'Logs', href: '/owner/logs', icon: ListChecks },
  { label: 'Settings', href: '/owner/settings', icon: Settings },
  { label: 'Feature Flags', href: '/owner/feature-flags', icon: Flag },
  { label: 'Demo Data', href: '/owner/demo-data', icon: Wrench },
];
