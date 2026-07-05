<?php

namespace App\Modules\Payments\Domain\Events;

final readonly class PaymentExpired
{
    public function __construct(public string $paymentUuid, public string $bookingUuid) {}
}
