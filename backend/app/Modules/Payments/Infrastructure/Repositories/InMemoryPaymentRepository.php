<?php

namespace App\Modules\Payments\Infrastructure\Repositories;

use App\Modules\Payments\Domain\Entities\Payment;
use App\Modules\Payments\Domain\Repositories\PaymentRepository;

final class InMemoryPaymentRepository implements PaymentRepository
{
    /** @var array<string, Payment> */
    private array $payments = [];
    /** @var array<string, array<string, mixed>> */
    private array $webhooks = [];

    public function findByUuid(string $uuid): ?Payment { return $this->payments[$uuid] ?? null; }
    public function findByIdempotencyKey(string $idempotencyKey): ?Payment
    {
        foreach ($this->payments as $payment) {
            if ($payment->idempotencyKey === $idempotencyKey) return $payment;
        }
        return null;
    }
    public function hasProcessedWebhook(string $gatewayReference): bool { return isset($this->webhooks[$gatewayReference]); }
    public function save(Payment $payment): Payment { $this->payments[$payment->uuid] = $payment; return $payment; }
    public function markWebhookProcessed(string $gatewayReference, array $payload): void { $this->webhooks[$gatewayReference] = $payload; }
}
