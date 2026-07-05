<?php

namespace App\Modules\CheckIn\Presentation;

use Illuminate\Http\JsonResponse;

final class CheckInController
{
    public function store(): JsonResponse { return response()->json(['success' => true, 'message' => 'Passenger checked in', 'data' => []]); }
    public function noShow(): JsonResponse { return response()->json(['success' => true, 'message' => 'Passenger marked no show', 'data' => []]); }
}
