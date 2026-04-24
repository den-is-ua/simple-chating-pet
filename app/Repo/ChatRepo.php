<?php

namespace App\Repo;


use App\Contracts\ChatRepoContract;
use App\Models\Chat;
use App\Supports\ChatListSupport;

class ChatRepo implements ChatRepoContract
{
    #[\Override]
    public function createNewChat(int $senderId, int $recipientId, string $message): ?string
    {
        $chat = Chat::query()->create([
            'sender_id' => $senderId,
            'recipient_id' => $recipientId,
            'last_message' => $message
        ]);
        
        return $chat->id;
    }
    
    #[\Override]
    public function removeChat($uuId): bool
    {
        $chat = Chat::findOrFail($uuId);
        return $chat->softDelete();
    }
    
    #[\Override]
    public function getAllChats(int $userId): ChatListSupport
    {
        $chats = Chat::query()
                ->where('sender_id', $userId)
                ->orWhere('recipient_id', $userId)
                ->get(['sender_id', 'recipient_id', 'last_message', 'sent_at']);
        
        $output = new ChatListSupport();
        
        foreach ($chats as $chat) {
            $output->add($chat);
        }
        
        return $output;
    }
}
