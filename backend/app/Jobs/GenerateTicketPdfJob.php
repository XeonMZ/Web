<?php

namespace App\Jobs;

final class GenerateTicketPdfJob
{
    /** @param array<string, mixed> $payload */
    public function __construct(public readonly array $payload) {}

    public function handle(): void
    {
        // Queue-ready placeholder for GenerateTicketPdfJob.
    }
}
