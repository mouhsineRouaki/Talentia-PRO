<?php

namespace App\Listeners;

use App\Events\MessageSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

// class SendMessageNotification
// {
//     public function handle(MessageSent $event)
//     {
//         $receiver = $event->message->receiver;

//         $receiver->notify(new NewMessageNotification($event->message));

//     }
// }
