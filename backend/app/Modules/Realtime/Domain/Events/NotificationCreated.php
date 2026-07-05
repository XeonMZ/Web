<?php

namespace App\Modules\Realtime\Domain\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

final readonly class NotificationCreated implements ShouldBroadcast
{
    public function __construct(public string $channel, public string $title, public string $message) {}
    public function broadcastOn(): array { return [new PrivateChannel($this->channel)]; }
    public function broadcastAs(): string { return 'notification.created'; }
    public function broadcastWith(): array { return ['title' => $this->title, 'message' => $this->message]; }
}
