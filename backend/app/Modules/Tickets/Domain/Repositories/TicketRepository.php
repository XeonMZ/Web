<?php

namespace App\Modules\Tickets\Domain\Repositories;

use App\Modules\Tickets\Domain\Entities\Ticket;

interface TicketRepository
{
    public function findByUuid(string $uuid): ?Ticket;
    public function findByTicketNumber(string $ticketNumber): ?Ticket;
    public function save(Ticket $ticket): Ticket;
}
