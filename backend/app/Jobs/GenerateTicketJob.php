<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\ActivityLog;
use App\Models\Booking;
use App\Models\Ticket;
use App\Modules\Booking\Application\Services\BookingService;
use App\Modules\Booking\Domain\Events\TicketGenerated;
use App\Modules\Booking\Domain\ValueObjects\BookingStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

final class GenerateTicketJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public function __construct(public readonly string $bookingUuid) {}
    public function handle(BookingService $bookings): void
    {
        $booking = $bookings->getBooking($this->bookingUuid);
        if (!$booking->ticket) {
            Ticket::create(['booking_id' => $booking->id, 'ticket_number' => 'TKT-'.Str::upper(Str::random(10)), 'qr_code' => Str::uuid()->toString(), 'status' => 'generated']);
        }
        $booking->update(['status' => BookingStatus::TicketGenerated->value]);
        ActivityLog::create(['action' => 'ticket.generated', 'subject_type' => Booking::class, 'subject_id' => $booking->id, 'metadata' => ['booking_uuid' => $booking->uuid]]);
        TicketGenerated::dispatch($booking->fresh());
    }
}
