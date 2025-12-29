<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Conversation;

Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    $conv = Conversation::find($conversationId);
    if (!$conv) return false;

    // customer pemilik convo
    if ((int)$conv->customer_id === (int)$user->id) return true;

    // admin yang menangani (atau admin mana pun boleh, pilih salah satu kebijakan)
    if ($user->role === 'admin') return true; // paling simpel
    // atau lebih ketat:
    // return (int)$conv->admin_id === (int)$user->id;

    return false;
});
