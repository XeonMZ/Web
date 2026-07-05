<?php

namespace App\Modules\Payments\Application\Services;

use App\Modules\Payments\Application\StateMachines\PaymentStateMachine;
use App\Modules\Payments\Domain\Entities\Payment;
use App\Modules\Payments\Domain\Repositories\PaymentGateway;
use App\Modules\Payments\Domain\Repositories\PaymentRepository;
use App\Modules\Payments\Domain\ValueObjects\PaymentStatus;
use RuntimeException;

final class PaymentWebhookHandler
{
    public function __construct(
        private readonly PaymentRepository $payments,
        private readonly PaymentGateway $gateway,
        private readonly PaymentStateMachine $states,
    ) {}

    /** @param array<string, mixed> $payload */
    public function handle(array $payload): Payment
    {
        $reference = (string) ($payload['order_id'] ?? '');
        if ($reference === '') throw new RuntimeException('Missing webhook order_id.');
        if ($this->payments->hasProcessedWebhook($reference)) {
            $payment = $this->payments->findByUuid($reference);
            if ($payment === null) throw new RuntimeException('Processed webhook payment not found.');
            return $payment;
        }
        if (! $this->gateway->verifyWebhook($payload)) throw new RuntimeException('Invalid payment webhook signature.');

        $payment = $this->payments->findByUuid($reference);
        if ($payment === null) throw new RuntimeException('Payment not found.');

        $next = $this->mapStatus((string) ($payload['transaction_status'] ?? ''));
        $this->states->assertCanTransition($payment->status, $next);
        $updated = new Payment($payment->uuid, $payment->bookingUuid, $payment->amount, $payment->method, $next, $payment->idempotencyKey, $payment->gatewayReference);
        $this->payments->save($updated);
        $this->payments->markWebhookProcessed($reference, $payload);

        return $updated;
    }

    private function mapStatus(string $gatewayStatus): PaymentStatus
    {
        return match ($gatewayStatus) {
            'settlement', 'capture' => PaymentStatus::Paid,
            'deny', 'cancel', 'failure' => PaymentStatus::Failed,
            'expire' => PaymentStatus::Expired,
            'refund' => PaymentStatus::Refunded,
            'partial_refund' => PaymentStatus::PartialRefunded,
            default => PaymentStatus::Pending,
        };
    }
}
