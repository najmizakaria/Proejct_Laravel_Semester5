<?php

use App\Models\Conversation;
use App\Models\User;

Broadcast::channel('convo.{conversationId}', function (User $user, string $conversationId) {
    return Conversation::where('id', $conversationId)
        ->whereHas('participants', fn ($q) => $q->where('users.id', $user->id))
        ->exists();
});