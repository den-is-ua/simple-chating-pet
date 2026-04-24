<?php

namespace App\Contracts;


use App\Supports\ChatListSupport;

interface ChatRepoContract
{
    public function createNewChat(int $senderId, int $recipientId, string $message): ?string;
    
    public function removeChat(string $uuId): bool;
    
    public function getAllChats(int $userId): ChatListSupport;
}
