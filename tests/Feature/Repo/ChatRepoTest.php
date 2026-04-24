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

test('removeChat soft deletes chat by uuid', function () {
    $sender = User::factory()->create();
    $recipient = User::factory()->create();

    $chatId = app(ChatRepo::class)->createNewChat(
        $sender->id,
        $recipient->id,
        'Message to remove',
    );

    $removed = app(ChatRepo::class)->removeChat($chatId);

    expect($removed)->toBeTrue();

    $this->assertSoftDeleted('chat', [
        'id' => $chatId,
    ]);
});

test('getAllChats returns only chats related to the user', function () {
    $user = User::factory()->create();
    $otherA = User::factory()->create();
    $otherB = User::factory()->create();

    app(ChatRepo::class)->createNewChat($user->id, $otherA->id, 'A to user');
    app(ChatRepo::class)->createNewChat($otherB->id, $user->id, 'user as recipient');
    app(ChatRepo::class)->createNewChat($otherA->id, $otherB->id, 'unrelated');

    $result = app(ChatRepo::class)->getAllChats($user->id);
    $list = $result->getList();

    expect($list)->toHaveCount(2);
    expect(
        $list->contains(fn ($chat) => $chat->sender_id === $user->id && $chat->recipient_id === $otherA->id),
    )->toBeTrue();
    expect(
        $list->contains(fn ($chat) => $chat->sender_id === $otherB->id && $chat->recipient_id === $user->id),
    )->toBeTrue();
});
