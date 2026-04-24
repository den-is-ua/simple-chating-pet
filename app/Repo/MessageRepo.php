<?php

namespace App\Repo;

use App\Contracts\MessageRepoContract;
use App\Services\DynamoDBService;
use App\Supports\MessageListSupport;
use Aws\DynamoDb\DynamoDbClient;
use Throwable;

class MessageRepo implements MessageRepoContract
{
    const TABLE = 'messages';
    
    readonly DynamoDbClient $dynamoDbClient;

    public function __construct()
    {
        $this->dynamoDbClient = (new DynamoDBService(self::TABLE))->client;
    }

    
    #[\Override]
    public function createNewMessage(string $chatId, int $senderId, int $recipientId, string $message): bool
    {
        $sentAt = (string) now()->getTimestampMs();
        $messageId = (int) $sentAt;

        try {
            $this->dynamoDbClient->putItem([
                'TableName' => self::TABLE,
                'Item' => [
                    'chat_id' => ['S' => $chatId],
                    'sent_at' => ['N' => $sentAt],
                    'message_id' => ['N' => (string) $messageId],
                    'sender_id' => ['N' => (string) $senderId],
                    'recipient_id' => ['N' => (string) $recipientId],
                    'message' => ['S' => $message],
                ],
            ]);

            return true;
        } catch (Throwable $exception) {
            logger()->error('Failed to create message in DynamoDB.', [
                'chat_id' => $chatId,
                'sender_id' => $senderId,
                'recipient_id' => $recipientId,
                'error' => $exception->getMessage(),
            ]);

            return false;
        }
    }

    #[\Override]
    public function getMessages(string $chatId, $limit, $lastMessageId): MessageListSupport
    {
        
    }
}
