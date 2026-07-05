<?php

namespace App\Modules\Payments\Domain\Events;

final readonly class PaymentSucceeded
{
    public function __construct(public string $paymentUuid, public string $bookingUuid) {}
}
