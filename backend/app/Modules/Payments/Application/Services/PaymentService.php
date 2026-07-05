<?php

namespace App\Modules\Payments\Application\Services;

use App\Modules\Payments\Domain\Entities\Payment;
use App\Modules\Payments\Domain\Repositories\PaymentGateway;
use App\Modules\Payments\Domain\Repositories\PaymentRepository;
use App\Modules\Payments\Domain\ValueObjects\PaymentStatus;

final class PaymentService
{
    public function __construct(
        private readonly PaymentRepository $payments,
        private readonly PaymentGateway $gateway,
    ) {}

    /** @return array{payment: Payment, gateway: array<string, string>} */
    public function createPayment(string $bookingUuid, int $amount, string $method, string $idempotencyKey): array
    {
        $existing = $this->payments->findByIdempotencyKey($idempotencyKey);
        if ($existing !== null) {
            return ['payment' => $existing, 'gateway' => ['reference' => (string) $existing->gatewayReference]];
        }

        $payment = new Payment(bin2hex(random_bytes(16)), $bookingUuid, $amount, $method, PaymentStatus::Pending, $idempotencyKey);
        $gatewayPayload = $this->gateway->createCharge($payment);
        $payment = new Payment($payment->uuid, $bookingUuid, $amount, $method, PaymentStatus::Pending, $idempotencyKey, $gatewayPayload['reference']);

        return ['payment' => $this->payments->save($payment), 'gateway' => $gatewayPayload];
    }
}
