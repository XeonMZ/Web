<?php

namespace App\Modules\Realtime\Application;

use App\Support\FeatureFlags\FeatureFlag;
use App\Support\FeatureFlags\FeatureFlagService;

final class RealtimeService
{
    public function __construct(private readonly FeatureFlagService $features) {}

    public function canBroadcast(): bool
    {
        return $this->features->enabled(FeatureFlag::Realtime);
    }

    public function canBroadcastGps(): bool
    {
        return $this->canBroadcast() && $this->features->enabled(FeatureFlag::Gps);
    }

    public function canBroadcastNotifications(): bool
    {
        return $this->canBroadcast() && $this->features->enabled(FeatureFlag::Notifications);
    }
}
