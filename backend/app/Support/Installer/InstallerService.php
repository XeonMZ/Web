<?php

declare(strict_types=1);

namespace App\Support\Installer;

use App\Models\{ActivityLog, Booking, Customer, Driver, FeatureFlag, Membership, Notification, Passenger, Payment, Promo, Route, Schedule, SystemSetting, Ticket, User, Vehicle, VehicleLayout, VehicleSeat, Voucher};
use Illuminate\Support\Facades\{Artisan, DB, Hash, Schema};
use Illuminate\Support\Str;
use RuntimeException;

final class InstallerService
{
    public function installed(): bool
    {
        if (! Schema::hasTable('system_settings')) {
            return false;
        }
        return (bool) (SystemSetting::query()->where('key', 'installer.locked')->value('value') ?? false);
    }

    public function requirements(): array
    {
        $db = $this->databaseReady();
        return [
            'php' => ['ok' => PHP_VERSION_ID >= 80200, 'message' => PHP_VERSION],
            'database' => ['ok' => $db, 'message' => $db ? 'Connected' : 'Unavailable'],
            'storage' => ['ok' => is_writable(storage_path()), 'message' => storage_path()],
            'queue' => ['ok' => (bool) config('queue.default'), 'message' => (string) config('queue.default')],
            'cache' => ['ok' => (bool) config('cache.default'), 'message' => (string) config('cache.default')],
            'reverb' => ['ok' => filled(config('broadcasting.connections.reverb.key')), 'message' => filled(config('broadcasting.connections.reverb.key')) ? 'Configured' : 'Not configured'],
        ];
    }

    public function install(array $payload): array
    {
        if ($this->installed()) {
            throw new RuntimeException('Installer is locked.');
        }

        return DB::transaction(function () use ($payload): array {
            $owner = User::query()->create(['name' => data_get($payload, 'owner.name'), 'email' => data_get($payload, 'owner.email'), 'password' => Hash::make((string) data_get($payload, 'owner.password')), 'role' => 'owner', 'email_verified_at' => now(), 'metadata' => ['created_by' => 'installer']]);
            $admin = User::query()->create(['name' => data_get($payload, 'admin.name'), 'email' => data_get($payload, 'admin.email'), 'password' => Hash::make((string) data_get($payload, 'admin.password')), 'role' => 'admin', 'email_verified_at' => now(), 'metadata' => ['created_by' => 'installer']]);

            foreach ([
                'company.profile' => data_get($payload, 'company'),
                'booking.seat_lock_minutes' => (int) data_get($payload, 'configuration.seat_lock_minutes', 10),
                'ticket.expiry_minutes' => (int) data_get($payload, 'configuration.ticket_expiry_minutes', 30),
                'payment.expiry_minutes' => (int) data_get($payload, 'configuration.payment_expiry_minutes', 15),
                'app.timezone' => data_get($payload, 'configuration.timezone', data_get($payload, 'company.timezone', 'UTC')),
                'app.language' => data_get($payload, 'configuration.language', 'en'),
                'app.currency' => data_get($payload, 'configuration.currency', data_get($payload, 'company.currency', 'USD')),
                'payment.midtrans' => data_get($payload, 'payment.midtrans'),
                'mail.smtp' => data_get($payload, 'mail'),
                'installer.completed_at' => now()->toISOString(),
            ] as $key => $value) {
                SystemSetting::query()->updateOrCreate(['key' => $key], ['value' => $value, 'is_public' => in_array($key, ['company.profile', 'app.timezone', 'app.language', 'app.currency'], true)]);
            }

            FeatureFlag::query()->updateOrCreate(['key' => 'installation_completed'], ['enabled' => true, 'metadata' => ['completed_at' => now()->toISOString()]]);
            $demo = (bool) data_get($payload, 'demo_data', false) ? $this->createDemoData() : [];
            if (blank(config('app.key'))) { Artisan::call('key:generate', ['--force' => true]); }
            SystemSetting::query()->updateOrCreate(['key' => 'installer.locked'], ['value' => true, 'is_public' => false]);
            ActivityLog::query()->create(['action' => 'installer.completed', 'subject_type' => User::class, 'subject_id' => $owner->id, 'metadata' => ['owner_uuid' => $owner->uuid, 'admin_uuid' => $admin->uuid, 'demo' => $demo]]);
            return ['owner_uuid' => $owner->uuid, 'admin_uuid' => $admin->uuid, 'demo' => $demo];
        });
    }

    private function databaseReady(): bool { try { DB::connection()->getPdo(); return true; } catch (\Throwable) { return false; } }

    private function createDemoData(): array
    {
        $tag = ['demo' => true, 'removable' => true, 'batch' => (string) Str::uuid()];
        $customerUser = User::create(['name' => 'Demo Customer', 'email' => 'demo.customer@stms.test', 'password' => Hash::make('password'), 'role' => 'customer', 'metadata' => $tag]);
        $driverUser = User::create(['name' => 'Demo Driver', 'email' => 'demo.driver@stms.test', 'password' => Hash::make('password'), 'role' => 'driver', 'metadata' => $tag]);
        $customer = Customer::create(['user_id' => $customerUser->id, 'phone' => '628000000001']);
        $driver = Driver::create(['user_id' => $driverUser->id, 'license_number' => 'DEMO-SIM-001', 'status' => 'available']);
        $layout = VehicleLayout::create(['name' => 'Demo Executive', 'capacity' => 4, 'metadata' => $tag]);
        $vehicle = Vehicle::create(['vehicle_layout_id' => $layout->id, 'plate_number' => 'D 1000 DEMO', 'code' => 'DEMO-BUS', 'brand' => 'Demo', 'status' => 'active']);
        VehicleSeat::create(['vehicle_id' => $vehicle->id, 'seat_number' => 'A1', 'class' => 'regular', 'is_active' => true]);
        $route = Route::create(['code' => 'DEMO-ROUTE', 'origin' => 'Demo Origin', 'destination' => 'Demo Destination', 'distance_km' => 10, 'duration_minutes' => 30]);
        $schedule = Schedule::create(['route_id' => $route->id, 'driver_id' => $driver->id, 'vehicle_id' => $vehicle->id, 'departure_at' => now()->addDay(), 'arrival_at' => now()->addDay()->addMinutes(30), 'base_fare' => 10000, 'status' => 'scheduled']);
        $booking = Booking::create(['code' => 'DEMO-BOOKING', 'schedule_id' => $schedule->id, 'customer_id' => $customer->id, 'status' => 'paid', 'amount' => 10000]);
        Passenger::create(['booking_id' => $booking->id, 'name' => 'Demo Passenger', 'identity_number' => 'DEMO-ID-001']);
        $ticket = Ticket::create(['booking_id' => $booking->id, 'ticket_number' => 'DEMO-TICKET', 'qr_code' => 'DEMO-QR', 'status' => 'issued']);
        $payment = Payment::create(['booking_id' => $booking->id, 'provider' => 'midtrans', 'reference' => 'DEMO-PAYMENT', 'amount' => 10000, 'status' => 'paid']);
        Notification::create(['user_id' => $customerUser->id, 'type' => 'system', 'title' => 'Demo notification', 'body' => 'Demo data can be removed later.', 'metadata' => $tag]);
        $promo = Promo::create(['code' => 'DEMO', 'name' => 'Demo Promo', 'amount' => 1000, 'starts_at' => now(), 'ends_at' => now()->addMonth()]);
        Voucher::create(['promo_id' => $promo->id, 'code' => 'DEMO1000', 'is_active' => true]);
        $membership = Membership::create(['customer_id' => $customer->id, 'level' => 'silver', 'points' => 10]);
        ActivityLog::create(['action' => 'demo.created', 'subject_type' => Booking::class, 'subject_id' => $booking->id, 'metadata' => $tag]);
        return ['booking' => $booking->uuid, 'ticket' => $ticket->uuid, 'payment' => $payment->uuid, 'membership' => $membership->uuid];
    }
}
