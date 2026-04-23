<?php

return [
    'default' => [
        'version' => env('AWS_SDK_VERSION', 'latest'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
        'credentials' => [
            'key' => env('AWS_ACCESS_KEY_ID', 'local'),
            'secret' => env('AWS_SECRET_ACCESS_KEY', 'local'),
        ],
    ],

    'dynamodb' => [
        'version' => env('AWS_DYNAMODB_VERSION', env('AWS_SDK_VERSION', 'latest')),
        'region' => env('AWS_DYNAMODB_REGION', env('AWS_DEFAULT_REGION', 'us-east-1')),
        'credentials' => [
            'key' => env('AWS_DYNAMODB_ACCESS_KEY_ID', env('AWS_ACCESS_KEY_ID', 'local')),
            'secret' => env('AWS_DYNAMODB_SECRET_ACCESS_KEY', env('AWS_SECRET_ACCESS_KEY', 'local')),
        ],
        'endpoint' => env('AWS_DYNAMODB_ENDPOINT', env('DYNAMODB_ENDPOINT', 'http://dynamodb-local:8000')),
        'table' => env('AWS_DYNAMODB_TABLE', 'messages'),
    ],
];

