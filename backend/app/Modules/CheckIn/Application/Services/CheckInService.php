<?php

namespace App\Modules\CheckIn\Application\Services;

use App\Modules\CheckIn\Domain\Entities\PassengerCheckIn;
use App\Modules\Tickets\Application\Services\TicketService;
use RuntimeException;

final class CheckInService
{
    public function __construct(private readonly TicketService $tickets) {}

    public function checkIn(string $qrPayload, string $driverUuid, ?float $latitude, ?float $longitude): PassengerCheckIn
    {
        $ticket = $this->tickets->validatePayload($qrPayload);
        if ($ticket->checkedIn) throw new RuntimeException('Ticket already checked in.');

        return new PassengerCheckIn($ticket->uuid, $driverUuid, $latitude, $longitude, 'checked_in', gmdate(DATE_ATOM));
    }

    public function noShow(string $ticketUuid, string $driverUuid, ?float $latitude, ?float $longitude): PassengerCheckIn
    {
        return new PassengerCheckIn($ticketUuid, $driverUuid, $latitude, $longitude, 'no_show', gmdate(DATE_ATOM));
    }
}
