<?php

namespace App\Modules\Tickets\Presentation;

use Illuminate\Http\JsonResponse;

final class TicketController
{
    public function index(): JsonResponse { return response()->json(['success' => true, 'message' => 'OK', 'data' => []]); }
    public function show(): JsonResponse { return response()->json(['success' => true, 'message' => 'OK', 'data' => []]); }
}
