<?php


namespace App\Services;

use Aws\DynamoDb\DynamoDbClient;


class DynamoDBService 
{
    public const MESSAGE_TABLE = 'messages';

    public $client;
    
    
    public function __construct(private string $table) 
    {
        $this->client = self::client();
    }
    
    public static function client()
    {
        static $client;
        
        if (is_null($client)) {
            $config = (array) config('aws.dynamodb', []);
            
            $client = new DynamoDbClient([
                'version' => $config['version'] ?? 'latest',
                'region' => $config['region'] ?? 'us-east-1',
                'credentials' => $config['credentials'] ?? [
                    'key' => 'local',
                    'secret' => 'local',
                ],
                'endpoint' => $config['endpoint'],
            ]);
        }
        
        return $client;
    }
}
