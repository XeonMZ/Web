<?php

namespace App\Modules\Payments\Domain\Events;

final readonly class PaymentFailed
{
    public function __construct(public string $paymentUuid, public string $bookingUuid) {}
}
