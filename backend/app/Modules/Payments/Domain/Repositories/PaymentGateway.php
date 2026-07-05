<?php

namespace App\Modules\Payments\Domain\Repositories;

use App\Modules\Payments\Domain\Entities\Payment;

interface PaymentGateway
{
    /** @return array{redirect_url?: string, qr_string?: string, va_number?: string, reference: string} */
    public function createCharge(Payment $payment): array;
    /** @param array<string, mixed> $payload */
    public function verifyWebhook(array $payload): bool;
}
