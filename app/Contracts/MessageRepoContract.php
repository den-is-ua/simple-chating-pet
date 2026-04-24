<?php

namespace App\Contracts;

use App\Supports\MessageListSupport;

interface MessageRepoContract
{
    public function createNewMessage(string $chatId, int $senderId, int $recipientId, string $message): bool;
    
    public function getMessages(string $chatId, $limit, $lastMessageId): MessageListSupport;
    
}
