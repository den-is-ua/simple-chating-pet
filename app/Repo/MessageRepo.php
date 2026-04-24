<?php

namespace App\Repo;

use App\Contracts\MessageRepoContract;
use App\Services\DynamoDBService;
use App\Supports\MessageListSupport;
use Throwable;

class MessageRepo implements MessageRepoContract
{
    private string $table = 'messages';

    protected function newDynamoDbService(): DynamoDBService
    {
        return new DynamoDBService($this->table);
    }

    
    #[\Override]
    public function createNewMessage(string $chatId, int $senderId, int $recipientId, string $message): bool
    {
        $sentAt = (string) now()->getTimestampMs();
        $messageId = (int) $sentAt;

        try {
            $dynamoDBClient = $this->newDynamoDbService()->client;
            $dynamoDBClient->putItem([
                'TableName' => $this->table,
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
