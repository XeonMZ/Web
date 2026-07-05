'use client';
import { useState } from 'react';
export type RealtimeNotification = { title: string; message: string };
export function useNotifications() { const [notifications, setNotifications] = useState<RealtimeNotification[]>([]); return { notifications, push: (notification: RealtimeNotification) => setNotifications((items) => [notification, ...items]) }; }
