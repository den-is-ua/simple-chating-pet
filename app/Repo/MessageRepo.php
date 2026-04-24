<?php

namespace App\Repo;

use App\Contracts\MessageRepoContract;
use App\Supports\MessageListSupport;

class MessageRepo implements MessageRepoContract
{
    
    #[\Override]
    public function createNewMessage(string $chatId, int $senderId, int $recipientId, string $message): bool
    {
        
    }

    #[\Override]
    public function getMessages(string $chatId, $limit, $lastMessageId): MessageListSupport
    {
        
    }
}
