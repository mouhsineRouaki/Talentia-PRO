<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Conversation;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('conversation.{id}', function ($user, $id) {
    $conversation = Conversation::find($id);
    if (!$conversation) {
        return false;
    }
    return in_array($user->id, [
            $conversation->user_one_id,
            $conversation->user_two_id
        ]);
});

Broadcast::channel('user.{id}', function ($user, $id) {
    return $user->id == $id;
});
Broadcast::channel('online', function ($user) {
    if (auth()->check()) {
        return ['id' => $user->id, 'name' => $user->name];
    }
});
