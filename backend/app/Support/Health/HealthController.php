<?php

namespace App\Support\Health;

use Illuminate\Http\JsonResponse;

final class HealthController
{
    public function health(): JsonResponse { return response()->json(['success' => true, 'message' => 'OK', 'data' => ['status' => 'healthy']]); }
    public function ready(): JsonResponse { return response()->json(['success' => true, 'message' => 'Ready', 'data' => ['database' => 'pending', 'cache' => 'pending']]); }
    public function version(): JsonResponse { return response()->json(['success' => true, 'message' => 'Version', 'data' => ['version' => getenv('APP_VERSION') ?: '0.1.0']]); }
}
