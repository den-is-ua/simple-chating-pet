<?php

use Illuminate\Database\Migrations\Migration;
use \App\Services\DynamoDBService;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $client = DynamoDBService::client();
       

        $client->createTable([
            'TableName' => 'messages',
            'AttributeDefinitions' => [
                ['AttributeName' => 'chat_id', 'AttributeType' => 'S'],
                ['AttributeName' => 'sent_at', 'AttributeType' => 'N'],
            ],
            'KeySchema' => [
                ['AttributeName' => 'chat_id', 'KeyType' => 'HASH'],
                ['AttributeName' => 'sent_at', 'KeyType' => 'RANGE'],
            ],
            'BillingMode' => 'PAY_PER_REQUEST',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $client = DynamoDBService::client();
        $client->deleteTable([
            'TableName' => DynamoDBService::MESSAGE_TABLE,
        ]);
    }

    
};
