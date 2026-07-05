<?php

namespace App\Modules\Payments\Domain\Repositories;

use App\Modules\Payments\Domain\Entities\Payment;

interface PaymentRepository
{
    public function findByUuid(string $uuid): ?Payment;
    public function findByIdempotencyKey(string $idempotencyKey): ?Payment;
    public function hasProcessedWebhook(string $gatewayReference): bool;
    public function save(Payment $payment): Payment;
    public function markWebhookProcessed(string $gatewayReference, array $payload): void;
}
