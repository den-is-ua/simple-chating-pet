<?php

use App\Repo\ChatRepo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('createNewChat stores chat and returns its id', function () {
    $sender = User::factory()->create();
    $recipient = User::factory()->create();
    $message = 'Hello from test';

    $chatId = app(ChatRepo::class)->createNewChat(
        $sender->id,
        $recipient->id,
        $message,
    );

    expect($chatId)->not->toBeNull();

    $this->assertDatabaseHas('chat', [
        'id' => $chatId,
        'sender_id' => $sender->id,
        'recipient_id' => $recipient->id,
        'last_message' => $message,
    ]);
});
