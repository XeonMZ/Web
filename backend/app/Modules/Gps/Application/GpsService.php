<?php

namespace App\Modules\Gps\Application;

use App\Jobs\BroadcastLocationJob;
use App\Modules\Gps\Domain\Entities\DriverLocation;
use App\Modules\Gps\Domain\Repositories\DriverLocationRepository;
use App\Modules\Realtime\Application\RealtimeService;
use App\Modules\Realtime\Domain\Events\DriverLocationUpdated;
use App\Support\Policies\OperationalPolicy;

final class GpsService
{
    /** @var array<string, bool> */
    private array $activeTrips = [];

    public function __construct(private readonly DriverLocationRepository $locations, private readonly OperationalPolicy $policy, private readonly RealtimeService $realtime) {}

    public function startTrip(string $tripId): int { $this->activeTrips[$tripId] = true; return $this->policy->gpsIntervalSeconds(); }
    public function stopTrip(string $tripId): void { $this->activeTrips[$tripId] = false; }
    public function enabled(string $tripId): bool { return ($this->activeTrips[$tripId] ?? false) && $this->realtime->canBroadcastGps(); }

    public function record(string $driverId, string $tripId, float $latitude, float $longitude): ?BroadcastLocationJob
    {
        if (! $this->enabled($tripId)) return null;
        $location = $this->locations->save(new DriverLocation($driverId, $tripId, $latitude, $longitude, gmdate(DATE_ATOM)));
        return new BroadcastLocationJob(new DriverLocationUpdated($location->driverId, $location->tripId, $location->latitude, $location->longitude, $location->recordedAt));
    }
}
