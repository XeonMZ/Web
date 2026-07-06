import { DriverMap, EarningsSummary, TodayTrips, TripTimeline } from '@/components/driver/cards';
export default function Page() { return <main className="mx-auto max-w-6xl space-y-6 p-6"><h1 className="text-3xl font-bold">Driver Trips</h1><TodayTrips/><TripTimeline/><EarningsSummary/><DriverMap/></main>; }
