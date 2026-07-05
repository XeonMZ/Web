<?php

use Illuminate\Support\Facades\Route;
use App\Support\Health\HealthController;

Route::get('health', [HealthController::class, 'health']);
Route::get('ready', [HealthController::class, 'ready']);
Route::get('version', [HealthController::class, 'version']);

Route::post('login', [\App\Modules\Auth\Presentation\AuthController::class, 'login'])->middleware('throttle:login');
Route::post('register', [\App\Modules\Auth\Presentation\AuthController::class, 'register'])->middleware('throttle:register');
Route::post('forgot-password', [\App\Modules\Auth\Presentation\AuthController::class, 'forgotPassword'])->middleware('throttle:password-reset');
Route::post('reset-password', [\App\Modules\Auth\Presentation\AuthController::class, 'resetPassword'])->middleware('throttle:password-reset');

Route::middleware(['auth:sanctum', 'active', 'maintenance'])->group(function (): void {
    Route::post('logout', [\App\Modules\Auth\Presentation\AuthController::class, 'logout']);
    Route::get('profile', [\App\Modules\Auth\Presentation\AuthController::class, 'profile'])->middleware('verified');
    Route::put('profile', [\App\Modules\Auth\Presentation\AuthController::class, 'updateProfile']);
    Route::put('change-password', [\App\Modules\Auth\Presentation\AuthController::class, 'changePassword']);
    Route::post('refresh', [\App\Modules\Auth\Presentation\AuthController::class, 'refresh']);
});


Route::middleware(['auth:sanctum', 'active', 'maintenance'])->group(function (): void {
    Route::post('booking', [\App\Modules\Booking\Presentation\BookingController::class, 'store'])->middleware('permission:booking:create');
    Route::post('booking/lock-seat', [\App\Modules\Booking\Presentation\BookingController::class, 'lockSeat'])->middleware('permission:booking:create');
    Route::post('booking/release-seat', [\App\Modules\Booking\Presentation\BookingController::class, 'releaseSeat'])->middleware('permission:booking:create');
    Route::post('booking/cancel', [\App\Modules\Booking\Presentation\BookingController::class, 'cancel'])->middleware('permission:booking:create');
    Route::get('booking/{id}', [\App\Modules\Booking\Presentation\BookingController::class, 'show'])->middleware('permission:ticket:read');
    Route::get('customer/bookings', [\App\Modules\Booking\Presentation\BookingController::class, 'customerBookings'])->middleware('permission:history:read');
});

Route::prefix('v1')->group(function (): void {
    Route::post('payments', [\App\Modules\Payments\Presentation\PaymentController::class, 'store']);
    Route::post('payments/webhook', [\App\Modules\Payments\Presentation\PaymentController::class, 'webhook']);
    Route::get('tickets', [\App\Modules\Tickets\Presentation\TicketController::class, 'index']);
    Route::get('tickets/{ticket}', [\App\Modules\Tickets\Presentation\TicketController::class, 'show']);
    Route::post('check-in', [\App\Modules\CheckIn\Presentation\CheckInController::class, 'store']);
    Route::post('check-in/no-show', [\App\Modules\CheckIn\Presentation\CheckInController::class, 'noShow']);
});
