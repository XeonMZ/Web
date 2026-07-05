<?php

use Illuminate\Support\Facades\Route;
use App\Support\Health\HealthController;

Route::get('health', [HealthController::class, 'health']);
Route::get('ready', [HealthController::class, 'ready']);
Route::get('version', [HealthController::class, 'version']);

Route::prefix('v1')->group(function (): void {
    Route::post('payments', [\App\Modules\Payments\Presentation\PaymentController::class, 'store']);
    Route::post('payments/webhook', [\App\Modules\Payments\Presentation\PaymentController::class, 'webhook']);
    Route::get('tickets', [\App\Modules\Tickets\Presentation\TicketController::class, 'index']);
    Route::get('tickets/{ticket}', [\App\Modules\Tickets\Presentation\TicketController::class, 'show']);
    Route::post('check-in', [\App\Modules\CheckIn\Presentation\CheckInController::class, 'store']);
    Route::post('check-in/no-show', [\App\Modules\CheckIn\Presentation\CheckInController::class, 'noShow']);
});
