<?php

namespace App\Repo;

use App\Contracts\MessageRepoContract;
use App\NoSqlModels\Message;
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
    public function getMessages(string $chatId, $limit = 20, $lastMessageId = null): MessageListSupport
    {
        $messageList = new MessageListSupport();

        $query = [
            'TableName' => self::TABLE,
            'KeyConditionExpression' => 'chat_id = :chat_id',
            'ExpressionAttributeValues' => [
                ':chat_id' => ['S' => $chatId],
            ],
            'Limit' => max(1, (int) $limit),
            'ScanIndexForward' => false,
        ];

        if (! is_null($lastMessageId)) {
            $query['ExclusiveStartKey'] = [
                'chat_id' => ['S' => $chatId],
                'sent_at' => ['N' => (string) $lastMessageId],
            ];
        }

        try {
            $result = $this->dynamoDbClient->query($query);
            $items = (array) ($result['Items'] ?? []);

            foreach ($items as $item) {
                $messageList->add(new Message(
                    chatId: $item['chat_id']['S'],
                    messageId: (int) $item['message_id']['N'],
                    senderId: (int) $item['sender_id']['N'],
                    recipientId: (int) $item['recipient_id']['N'],
                    message: $item['message']['S'],
                    sent_at: (int) $item['sent_at']['N'],
                ));
            }
        } catch (Throwable $exception) {
            logger()->error('Failed to get messages from DynamoDB.', [
                'chat_id' => $chatId,
                'limit' => $limit,
                'last_message_id' => $lastMessageId,
                'error' => $exception->getMessage(),
            ]);
        }

        return $messageList;
    }
}
