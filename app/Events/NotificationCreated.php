<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;

    public function __construct(Notification $notification) {
        $this->notification = $notification;
    }

    public function broadcastOn() {
        return new PrivateChannel('user.' . $this->notification->user_id);
    }

    public function broadcastAs() {
        return 'notification.created';
    }

    public function broadcastWith() {
        return [
            'notification' => [
                'id' => $this->notification->id,
                'contenu' => $this->notification->contenu,
                'date_envoyer' => $this->notification->date_envoyer,
                'type' => $this->getNotificationType($this->notification->contenu),
            ]
        ];
    }

    protected function getNotificationType($content) {
        if (str_contains($content, 'Offre'))
            return 'offer';
        if (str_contains($content, 'amitié'))
            return 'friend_request';
        if (str_contains($content, 'accepté'))
            return 'accepted';
        return 'info';
    }
}
