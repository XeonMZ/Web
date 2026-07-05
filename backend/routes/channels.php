<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('customer.{bookingId}', fn ($user, string $bookingId): bool => (bool) $user);
Broadcast::channel('driver.{driverId}', fn ($user, string $driverId): bool => (bool) $user);
Broadcast::channel('admin', fn ($user): bool => (bool) $user);
Broadcast::channel('owner', fn ($user): bool => (bool) $user);
