<?php

namespace App\Modules\Gps\Domain\Entities;

final readonly class DriverLocation
{
    public function __construct(public string $driverId, public string $tripId, public float $latitude, public float $longitude, public string $recordedAt) {}
}
