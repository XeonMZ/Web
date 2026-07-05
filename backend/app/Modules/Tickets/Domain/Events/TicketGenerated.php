<?php

namespace App\Modules\Tickets\Domain\Events;

final readonly class TicketGenerated
{
    public function __construct(public string $ticketUuid, public string $bookingUuid) {}
}
