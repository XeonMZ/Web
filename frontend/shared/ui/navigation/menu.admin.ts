import { BarChart3, Bell, BookOpen, Bus, CalendarClock, ClipboardCheck, LayoutDashboard, Receipt, Settings, Ticket, Users, UserRound, Route } from 'lucide-react';
import type { MenuItem } from './types';

export const adminMenu: MenuItem[] = [
  { label: 'Dashboard', href: '/admin', icon: LayoutDashboard },
  { label: 'Booking', href: '/booking', icon: BookOpen },
  { label: 'Customers', href: '/admin/customers', icon: UserRound },
  { label: 'Trips', href: '/admin/trips', icon: Route },
  { label: 'Schedules', href: '/admin/schedules', icon: CalendarClock },
  { label: 'Vehicles', href: '/admin/vehicles', icon: Bus },
  { label: 'Drivers', href: '/admin/drivers', icon: Users },
  { label: 'Payments', href: '/payment', icon: Receipt },
  { label: 'Tickets', href: '/ticket', icon: Ticket },
  { label: 'Check-in', href: '/driver/check-in', icon: ClipboardCheck },
  { label: 'Notifications', href: '/admin/notifications', icon: Bell },
  { label: 'Reports', href: '/admin/reports', icon: BarChart3 },
  { label: 'Settings', href: '/admin/settings', icon: Settings },
];
