<?php

namespace App\Modules\Payments\Presentation;

use Illuminate\Http\JsonResponse;

final class PaymentController
{
    public function store(): JsonResponse { return response()->json(['success' => true, 'message' => 'Payment created', 'data' => []], 201); }
    public function webhook(): JsonResponse { return response()->json(['success' => true, 'message' => 'Webhook processed', 'data' => []]); }
}
