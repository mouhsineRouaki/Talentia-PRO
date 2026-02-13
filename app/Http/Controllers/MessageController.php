<?php

use App\Events\MessageSent;
use App\Models\Message;
use App\Notifications\NewMessageNotification;

$message = Message::create([
    'sender_id' => auth()->id(),
    'receiver_id' => $receiverId,
    'content' => $request->content,
]);

// Fire event for realtime
event(new MessageSent($message));

// Store in database + email
$receiver = $message->receiver;
$receiver->notify(new NewMessageNotification($message));
