<?php

namespace App\Modules\Tickets\Infrastructure\Repositories;

use App\Modules\Tickets\Domain\Entities\Ticket;
use App\Modules\Tickets\Domain\Repositories\TicketRepository;

final class InMemoryTicketRepository implements TicketRepository
{
    /** @var array<string, Ticket> */
    private array $tickets = [];
    public function findByUuid(string $uuid): ?Ticket { return $this->tickets[$uuid] ?? null; }
    public function findByTicketNumber(string $ticketNumber): ?Ticket
    {
        foreach ($this->tickets as $ticket) {
            if ($ticket->ticketNumber === $ticketNumber) return $ticket;
        }
        return null;
    }
    public function save(Ticket $ticket): Ticket { $this->tickets[$ticket->uuid] = $ticket; return $ticket; }
}
