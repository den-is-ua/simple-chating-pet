<?php

namespace App\NoSqlModels;

readonly class Message
{
    public function __construct(
        public string $chatId,
        public int $messageId,
        public int $senderId,
        public int $recipientId,
        public string $message,
        public int $sent_at,
    ) {}
}
