import { BadgePercent, Bell, BookOpen, CreditCard, LayoutDashboard, Star, Ticket, UserCircle } from 'lucide-react';
import type { MenuItem } from './types';

export const customerMenu: MenuItem[] = [
  { label: 'Dashboard', href: '/customer', icon: LayoutDashboard },
  { label: 'Booking', href: '/booking', icon: BookOpen },
  { label: 'Tickets', href: '/ticket', icon: Ticket },
  { label: 'Payments', href: '/payment', icon: CreditCard },
  { label: 'Membership', href: '/customer/membership', icon: Star },
  { label: 'Promo', href: '/customer/promo', icon: BadgePercent },
  { label: 'Notifications', href: '/customer/notifications', icon: Bell },
  { label: 'Profile', href: '/customer/profile', icon: UserCircle },
];
