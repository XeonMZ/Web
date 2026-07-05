<?php

namespace App\Modules\Payments\Domain\Entities;

use App\Modules\Payments\Domain\ValueObjects\PaymentStatus;

final class Payment
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $bookingUuid,
        public readonly int $amount,
        public readonly string $method,
        public readonly PaymentStatus $status,
        public readonly string $idempotencyKey,
        public readonly ?string $gatewayReference = null,
    ) {}
}
