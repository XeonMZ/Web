<?php

namespace App\Modules\Tickets\Application\Services;

use App\Modules\Tickets\Domain\Entities\Ticket;
use App\Modules\Tickets\Domain\Repositories\TicketRepository;
use App\Modules\Tickets\Infrastructure\Storage\TicketStorage;
use RuntimeException;

final class TicketService
{
    public function __construct(
        private readonly TicketRepository $tickets,
        private readonly TicketStorage $storage,
        private readonly string $signatureSecret,
    ) {}

    public function generate(string $bookingUuid, string $tripUuid, string $passengerUuid): Ticket
    {
        $ticketUuid = bin2hex(random_bytes(16));
        $ticketNumber = 'STMS-' . strtoupper(substr($ticketUuid, 0, 10));
        $signature = $this->signature($bookingUuid, $ticketUuid, $tripUuid, $passengerUuid);
        $payload = json_encode([
            'booking_uuid' => $bookingUuid,
            'ticket_uuid' => $ticketUuid,
            'trip_uuid' => $tripUuid,
            'passenger_uuid' => $passengerUuid,
            'signature' => $signature,
        ], JSON_THROW_ON_ERROR);
        $path = $this->storage->put('tickets/qr/' . $ticketUuid . '.txt', $payload);

        return $this->tickets->save(new Ticket($ticketUuid, $bookingUuid, $tripUuid, $passengerUuid, $ticketNumber, $payload, $path));
    }

    public function validatePayload(string $payload): Ticket
    {
        $decoded = json_decode($payload, true, 512, JSON_THROW_ON_ERROR);
        if (! is_array($decoded)) throw new RuntimeException('Invalid QR payload.');
        foreach (['booking_uuid', 'ticket_uuid', 'trip_uuid', 'passenger_uuid', 'signature'] as $key) {
            if (! isset($decoded[$key]) || ! is_string($decoded[$key])) throw new RuntimeException('Invalid QR payload field.');
        }
        $expected = $this->signature($decoded['booking_uuid'], $decoded['ticket_uuid'], $decoded['trip_uuid'], $decoded['passenger_uuid']);
        if (! hash_equals($expected, $decoded['signature'])) throw new RuntimeException('Invalid QR signature.');
        $ticket = $this->tickets->findByUuid($decoded['ticket_uuid']);
        if ($ticket === null) throw new RuntimeException('Ticket not found.');
        return $ticket;
    }

    private function signature(string $bookingUuid, string $ticketUuid, string $tripUuid, string $passengerUuid): string
    {
        return hash_hmac('sha256', $bookingUuid . '|' . $ticketUuid . '|' . $tripUuid . '|' . $passengerUuid, $this->signatureSecret);
    }
}
